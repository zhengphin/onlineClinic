<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>PeerChat</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
        *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

#videos{
    display: grid;
    grid-template-columns: 1fr;
    height: 100vh;
    overflow:hidden;
}

.video-player{
    background-color: black;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#user-2{
    display: none;
}

.smallFrame{
    position: fixed;
    top: 20px;
    left: 20px;
    height: 170px;
    width: 300px;
    border-radius: 5px;
    border:2px solid #b366f9;
    -webkit-box-shadow: 3px 3px 15px -1px rgba(0,0,0,0.77);
    box-shadow: 3px 3px 15px -1px rgba(0,0,0,0.77);
    z-index: 999;
}


#controls{
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform:translateX(-50%);
    display: flex;
    gap: 1em;
}


.control-container{
  background-color: rgb(179, 102, 249, .9);
  padding: 20px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.control-container img{
    height: 30px;
    width: 30px;
}

#leave-btn{
    background-color: rgb(255,80,80, 1);
}

@media screen and (max-width:600px) {
        .smallFrame{
            height: 80px;
            width: 120px;
        }

        .control-container img{
            height: 20px;
            width: 20px;
        }
}
    </style>
</head>
<body>

    <div id="videos">
        <video class="video-player" id="user-1" autoplay playsinline></video>
        <video class="video-player" id="user-2" autoplay playsinline></video>
    </div>

    <div id="controls">

        <div class="control-container" id="camera-btn">
            <img src="../icons/camera.png" />
        </div>

        <div class="control-container" id="mic-btn">
            <img src="../icons/mic.png" />
        </div>

        <a href="lobby.html">
            <div class="control-container" id="leave-btn">
                <img src="../icons/phone.png" />
            </div>
        </a>

    </div>
    <script src='../../agora-rtm-sdk-1.4.4.js'></script>
<script>
let APP_ID = "4a0c1a413bcd46bc80aa029ac2aa4906"


let token = null;
let uid = String(Math.floor(Math.random() * 10000))

let client;
let channel;

let queryString = window.location.search
let urlParams = new URLSearchParams(queryString)
let roomId = urlParams.get('room')

if(!roomId){
    window.location = 'lobby.html'
}

let localStream;
let remoteStream;
let peerConnection;

const servers = {
    iceServers:[
        {
            urls:['stun:stun1.l.google.com:19302', 'stun:stun2.l.google.com:19302']
        }
    ]
}


let constraints = {
        video:true,

    audio:true
}

let init = async () => {
    client = await AgoraRTM.createInstance(APP_ID)
    await client.login({uid, token})

    channel = client.createChannel(roomId)
    await channel.join()

    channel.on('MemberJoined', handleUserJoined)
    channel.on('MemberLeft', handleUserLeft)

    client.on('MessageFromPeer', handleMessageFromPeer)

    localStream = await navigator.mediaDevices.getUserMedia(constraints)
    document.getElementById('user-1').srcObject = localStream
}
 

let handleUserLeft = (MemberId) => {
    document.getElementById('user-2').style.display = 'none'
    document.getElementById('user-1').classList.remove('smallFrame')
}

let handleMessageFromPeer = async (message, MemberId) => {

    message = JSON.parse(message.text)

    if(message.type === 'offer'){
        createAnswer(MemberId, message.offer)
    }

    if(message.type === 'answer'){
        addAnswer(message.answer)
    }

    if(message.type === 'candidate'){
        if(peerConnection){
            peerConnection.addIceCandidate(message.candidate)
        }
    }


}

let handleUserJoined = async (MemberId) => {
    console.log('A new user joined the channel:', MemberId)
    createOffer(MemberId)
}


let createPeerConnection = async (MemberId) => {
    peerConnection = new RTCPeerConnection(servers)

    remoteStream = new MediaStream()
    document.getElementById('user-2').srcObject = remoteStream
    document.getElementById('user-2').style.display = 'block'

    document.getElementById('user-1').classList.add('smallFrame')


    if(!localStream){
        localStream = await navigator.mediaDevices.getUserMedia({video:true, audio:false})
        document.getElementById('user-1').srcObject = localStream
    }

    localStream.getTracks().forEach((track) => {
        peerConnection.addTrack(track, localStream)
    })

    peerConnection.ontrack = (event) => {
        event.streams[0].getTracks().forEach((track) => {
            remoteStream.addTrack(track)
        })
    }

    peerConnection.onicecandidate = async (event) => {
        if(event.candidate){
            client.sendMessageToPeer({text:JSON.stringify({'type':'candidate', 'candidate':event.candidate})}, MemberId)
        }
    }
}

let createOffer = async (MemberId) => {
    await createPeerConnection(MemberId)

    let offer = await peerConnection.createOffer()
    await peerConnection.setLocalDescription(offer)

    client.sendMessageToPeer({text:JSON.stringify({'type':'offer', 'offer':offer})}, MemberId)
}


let createAnswer = async (MemberId, offer) => {
    await createPeerConnection(MemberId)

    await peerConnection.setRemoteDescription(offer)

    let answer = await peerConnection.createAnswer()
    await peerConnection.setLocalDescription(answer)

    client.sendMessageToPeer({text:JSON.stringify({'type':'answer', 'answer':answer})}, MemberId)
}


let addAnswer = async (answer) => {
    if(!peerConnection.currentRemoteDescription){
        peerConnection.setRemoteDescription(answer)
    }
}


let leaveChannel = async () => {
    await channel.leave()
    await client.logout()
}

let toggleCamera = async () => {
    let videoTrack = localStream.getTracks().find(track => track.kind === 'video')

    if(videoTrack.enabled){
        videoTrack.enabled = false
        document.getElementById('camera-btn').style.backgroundColor = 'rgb(255, 80, 80)'
    }else{
        videoTrack.enabled = true
        document.getElementById('camera-btn').style.backgroundColor = 'rgb(179, 102, 249, .9)'
    }
}

let toggleMic = async () => {
    let audioTrack = localStream.getTracks().find(track => track.kind === 'audio')

    if(audioTrack.enabled){
        audioTrack.enabled = false
        document.getElementById('mic-btn').style.backgroundColor = 'rgb(255, 80, 80)'
    }else{
        audioTrack.enabled = true
        document.getElementById('mic-btn').style.backgroundColor = 'rgb(179, 102, 249, .9)'
    }
}
  
window.addEventListener('beforeunload', leaveChannel)

document.getElementById('camera-btn').addEventListener('click', toggleCamera)
document.getElementById('mic-btn').addEventListener('click', toggleMic)

init()
</script>
</body>
</html>