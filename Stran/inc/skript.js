// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function () {
	modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
	modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

//TINYMCE EDITOR 
console.log("pri tinymce")
tinymce.init({
	selector: '#mytextarea', //ID textareea 
	plugins: [
    'advlist autolink link image lists charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
    'table emoticons template paste help'
  ],
	toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' + //VSE KA BO V EDITORJU
		'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
		'forecolor backcolor emoticons | help',
	menu: {
		favs: {
			title: 'My Favorites',
			items: 'code visualaid | searchreplace | emoticons'
		}
	},
	menubar: 'favs file edit view insert format tools table help',
	content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
	paste_data_images: true, //Da lahko slike drag and drop
	mobile: { //Združljivo z telefonom
		menubar: true
	},
	entity_encoding : "raw",
	//images_upload_url: './postAcceptor.php',
	//automatic_uploads: false,
  	images_upload_base_path: 'img/',
  	images_upload_handler: function(blobInfo, success, failure){
		
		var xhr, formData;
      
        	xhr = new XMLHttpRequest();
        	xhr.withCredentials = false;
        	xhr.open('POST', './postAcceptor.php');
      
        	xhr.onload = function() {
            var json;
        
            if (xhr.status != 200) {
                failure('HTTP Error feget: ' + xhr.status);
                return;
            }
        
            json = JSON.parse(xhr.responseText); 
        
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
        
            success(json.location);
        };
      
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
      
        xhr.send(formData);
    }
		
	


});


document.getElementById("log-in").onclick = function () {
	location.href = "login.php";
};
document.getElementById("reg-in").onclick = function () {
	location.href = "register.php";
};
