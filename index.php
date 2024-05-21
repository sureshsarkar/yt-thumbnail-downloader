<?php 
// Checking if URL is submitted or not 
if (isset($_POST['button'])) { 
	// Fetching the URL 
	$img_URl = $_POST['img-url']; 
	// Initializing cURL 
	$c_URL = curl_init($img_URl); 
	// Setting options for cURL 
	curl_setopt($c_URL, CURLOPT_RETURNTRANSFER, 1); 
	// Downloading the image 
	$download_Img = curl_exec($c_URL); 
	// Closing cURL 
	curl_close($c_URL); 

	// Setting image details 
	header('Content-type: image/jpg'); 
	header('Content-Disposition: attachment;filename="yt-thumbnail.jpg"'); 

	// Output the downloaded image 
	echo $download_Img; 
} 
?> 

<!DOCTYPE html> 
<html> 

<head> 
	<title>Download YouTube Video Thumbnail</title> 
	<link rel="stylesheet" href="style.css"> 
	<!-- For using icons from font awesome --> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" /> 
</head> 
<style>
    * { 
margin: 0; 
padding: 0; 
box-sizing: border-box; 
font-family: monospace; 
} 

body { 
display: flex; 
align-items: center; 
justify-content: center; 
min-height: 100vh; 
background: black; 
} 

/* Style for form */
form { 
width: 490px; 
background: #fff; 
padding: 20px; 
border-radius: 10px; 
} 

/* Style for heading */
form header { 
text-align: center; 
font-size: 30px; 
font-weight: 900; 
color: #e82a2a; 
} 

/* Style for input section */
form .url-input { 
margin: 30px 0; 
} 
.url-input .heading { 
font-size: 15px; 
color: #e82a2a; 
} 
.url-input .input-field { 
margin-top: 10px; 
height: 40px; 
width: 100%; 
} 
.url-input .input-field input { 
height: 100%; 
width: 100%; 
border: none; 
outline: none; 
padding: 0 15px; 
font-size: 15px; 
background: #f1f1f7; 
border-radius: 10px; 
} 
.url-input .input-field input::placeholder { 
color: #b3b3b3; 
} 

/* Style for preview section */
form .preview-area { 
border-radius: 10px; 
height: 220px; 
display: flex; 
overflow: hidden; 
align-items: center; 
justify-content: center; 
flex-direction: column; 
border: 2px dotted #e82a2a; 
} 
.preview-area .thumbnail { 
width: 100%; 
display: none; 
border-radius: 10px; 
} 
.preview-area .icon { 
color: #e82a2a; 
font-size: 80px; 
} 
.preview-area span { 
color: #e82a2a; 
margin-top: 25px; 
font-size: 15px; 
font-weight: 600; 
} 
.preview-area.active { 
border: none; 
} 
.preview-area.active .thumbnail { 
display: block; 
} 
.preview-area.active .icon, 
.preview-area.active span { 
display: none; 
} 

/* Style for download button */
form .download-button { 
color: #fff; 
height: 50px; 
width: 100%; 
outline: none; 
border: none; 
font-size: 18px; 
font-weight: 900; 
cursor: pointer; 
margin-top: 20px; 
border-radius: 10px; 
background: #e82a2a; 
} 
.download-button:hover { 
background: #db0000; 
}


</style>
<body> 
	<!-- Form for submitting the youtube video url --> 
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
		<header>Download YouTube Thumbnail</header> 

		<!-- Input section --> 
		<div class="url-input"> 
			<span class="heading">Paste video url:</span> 
			<div class="input-field"> 
				<input type="text" placeholder="https://www.youtube.com/..." required> 
				<input class="hidden-input" type="hidden" name="img-url"> 
				<span class="bottom-line"></span> 
			</div> 
		</div> 

		<!-- Preview section --> 
		<div class="preview-area"> 
			<img class="thumbnail" src="" alt=""> 
			<i class="icon fa-solid fa-play"></i> 
			<span>Paste video url to see preview</span> 
		</div> 

		<!-- Download button --> 
		<button class="download-button" type="submit" name="button">Download Thumbnail</button> 
	</form> 

	<script src="script.js"></script> 
</body> 

</html>

<script>
    // Selecting relevant HTML elements using querySelector 
const urlField = document.querySelector(".input-field input"); 
const previewArea = document.querySelector(".preview-area"); 
const imgTag = previewArea.querySelector(".thumbnail"); 
const hidden = document.querySelector(".hidden-input"); 

urlField.onkeyup = () => { 
	// Fetching the entered YouTube video URL 
	let img_URl = urlField.value; 

	// Adding 'active' class to enable the thumbnail preview 
	previewArea.classList.add("active"); 

	// Check different YouTube video URL formats and set thumbnail preview accordingly 
	if (img_URl.indexOf("https://www.youtube.com/watch?v=") != -1) { 
		// Extract video ID from the URL 
		let vidId = img_URl.split("v=")[1].substring(0, 11); 
		// Construct YouTube thumbnail URL using maxresdefault quality 
		let ytImg_URl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`; 
		// Set the thumbnail preview image source 
		imgTag.src = ytImg_URl; 
	} 
	// Short URL format 
	else if (img_URl.indexOf("https://youtu.be/") != -1) { 
		// Extract video ID 
		let vidId = img_URl.split("be/")[1].substring(0, 11); 
		// Construct YouTube thumbnail URL using maxresdefault quality 
		let ytImg_URl = `https://img.youtube.com/vi/${vidId}/maxresdefault.jpg`; 
		// Set the thumbnail preview image source 
		imgTag.src = ytImg_URl; 
	} 
	// If the entered URL is a direct image URL 
	else if (img_URl.match(/\.(jpe?g|png|gif|bmp|webp)$/i)) { 
		imgTag.src = img_URl; 
	} 
	// If none of the above conditions are met 
	else { 
		imgTag.src = ""; 
		previewArea.classList.remove("active"); 
	} 

	// Set the value of the hidden input field to the image URL for form submission 
	hidden.value = imgTag.src; 
}; 

</script>