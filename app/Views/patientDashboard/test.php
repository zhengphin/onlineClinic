<html>
<head>
    <title>upload image to firebase</title>
</head>
<body>
    <form enctype="multipart/form-data">
        <label>select image : </label>
        <input type="file" id="image" accept="image/*"><br><br>
        <button type="button" onclick="upload()">Upload</button>
    </form>






<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#config-web-app -->

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyCYDTSlu86SpiE0LdrUN5EAd6-YmnxNAeo",
    authDomain: "onlineclinic-37b72.firebaseapp.com",
    databaseURL: "https://onlineclinic-37b72-default-rtdb.firebaseio.com",
    projectId: "onlineclinic-37b72",
    storageBucket: "onlineclinic-37b72.appspot.com",
    messagingSenderId: "89928964980",
    appId: "1:89928964980:web:2f2066ce881d9f6433ea21",
    measurementId: "G-B0M9LJL9XZ"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
</script>
<script>
    function upload() {
    //get your select image
    var image=document.getElementById("image").files[0];
    //now get your image name
    var imageName=image.name;
    //firebase  storage reference
    //it is the path where yyour image will store
    var storageRef=firebase.storage().ref('userImage/'+imageName);
    //upload image to selected storage reference

    var uploadTask=storageRef.put(image);

    uploadTask.on('state_changed',function (snapshot) {
        //observe state change events such as progress , pause ,resume
        //get task progress by including the number of bytes uploaded and total
        //number of bytes
        var progress=(snapshot.bytesTransferred/snapshot.totalBytes)*100;
        console.log("upload is " + progress +" done");
    },function (error) {
        //handle error here
        console.log(error.message);
    },function () {
       //handle successful uploads on complete

        uploadTask.snapshot.ref.getDownloadURL().then(function (downlaodURL) {
            //get your upload image url here...
            console.log(downlaodURL);
        });
    });
}
</script>
</body>
</html>