
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];

// ko uporabnik klikne na gumb, ustvari blog se mu prikaže pojavno okno
btn.onclick = function () {
	modal.style.display = "block";
}

// Za preklic pojavnega okna
span.onclick = function () {
	modal.style.display = "none";
}
//če uporabnik, klikne zraven pojavenga okna se to okno zapre
window.onclick = function (event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

//ZAMENJAJ PROFILNO SLIKO
function zamsliko(){
    var btn2 = document.getElementById("gumbek");
    
    var prik = document.getElementById("zamprof");
    btn2.onclick= function () {
        prik.style.display = "block";
        btn2.style.display = "none";
    }

    var btn3 = document.getElementById("nasliki");
    btn3.onclick = function () {
        btn3.style.display = "none";
    } 
 }

	
//FUNKCIJA za nalaganje slik v strežnik
function imageHandler (blobInfo, success, failure, progress) {
  var xhr, formData;

  xhr = new XMLHttpRequest();
  xhr.withCredentials = false;
  xhr.open('POST', "postAcceptor.php");

  xhr.upload.onprogress = function (e) {
    progress(e.loaded / e.total * 100);
  };

  xhr.onload = function() {
    var json;

    if (xhr.status === 403) {
      failure('HTTP Error asd: ' + xhr.status, { remove: true });
      return;
    }

    if (xhr.status < 200 || xhr.status >= 300) {
      failure('HTTP Error das: ' + xhr.status);
      return;
    }
    console.log(xhr.responseText);
    json = JSON.parse(xhr.responseText); //dodaj v json lokacijo slike
    
    if (!json || typeof json.location != 'string') {
      failure('Invalid JSON da: ' + xhr.responseText);
      return;
    }

    success(json.location);
  };

  xhr.onerror = function () {
    failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
  };

  formData = new FormData();
  formData.append('file', blobInfo.blob(), blobInfo.filename());

  xhr.send(formData);
};


//Ob kliku na like se doda všeček in spremeni slika like gumba
$('.like').on('click', function(){
    var lajkid = $(this).attr('id');
    var lajkslika = $(this).find(".lajkpot");
    
    var ajkid = lajkid.substring(1);
    var jkid = lajkid.substring(2);
    var likes = $("#"+jkid).text();
    var clas = $('#'+ajkid).attr('class').split(' ')[2]
    
    if(clas == "lajkb"){
    $.ajax({ //ajax za like gumb... V friendrequest pošlje podatke, ki se nato dodajo v bazo, nato pa se spremeni like gumb
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'lajked', idlajka: lajkid},
        success: function(data){           
            console.log("dela success");
            lajkslika.attr('src', 'assets/lajk1.svg');
            $("#"+ajkid).toggleClass('lajkw lajkb');
            $("#"+jkid).html(Number(likes)+1);
            //$("#"+ajkid).load(location.href +  ' #'+ajkid);
           
            //document.getElementById(lajkid).innerHTML = data;
        }
    });
  }
    else if (clas == "lajkw"){
        
       $.ajax({ //obratno zgornjemu primeru... Gumb za odstranitev všečka. 
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'unlajk', idlajka: lajkid},
        success: function(data){           
            console.log(data);
            lajkslika.attr('src', 'assets/lajk0.svg');
            $("#"+ajkid).toggleClass('lajkw lajkb'); //Zamenja se class pri gumbu.
            $("#"+jkid).html(Number(likes)-1);
            //$("#"+ajkid).load(location.href +  ' #'+ajkid);
            
        }
    }) 
    }
    
})

function friendrequest(idgumba, userid, friendid){ //fukncija ki se aktivira ob poslani prošnji za prijatelja... 
    console.log(userid);
    console.log(friendid);
    console.log(idgumba);
    
    $.ajax({
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'requestfriends', userid: userid, friendid: friendid},
        success: function(data){           
            document.getElementById(idgumba).innerHTML = "POSLANO"; //Gumb se spremeni v poslano in postane onemogočen
            document.getElementById(idgumba).disabled = true;
        }
    })
    
}

$('#prijatelji').on('click', function(){ //toogle med blogi od uporabnika in njegovimi prijatelji.. Funkcija se aktivira ob kliku na gumb Prijatelji
    
    $('#userblogs').toggle();
    $('#userfriends').toggle();
    
})

$('.sprejmi').on('click', function(){ //Ob kliku na gum sprejmi se uporabnika sprejme in doda v bazo, kot prijatelja
    
    sprejmiid = $(this).prop('id');
    console.log(sprejmiid);
    console.log("test");
    
    $.ajax({
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'acceptFriendReq', sprejeto: sprejmiid},
        success: function(data){
            console.log("dela");
            document.getElementById(sprejmiid).innerHTML = "SPREJETO";
            document.getElementById(sprejmiid).disabled = true;
            console.log(document.getElementById(sprejmiid));
            location.reload("UserProfile.html");
       
    }
    })
    
})

$('.zavrzi').on('click', function(){ //zavrzi prošnjo za prijateljstvo in jo izbriše iz baze
    
    zavrziid = $(this).prop('id');
    
    $.ajax({
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'denyFriendReq', zavrnjeno: zavrziid},
        success: function(data){
        console.log("dela");
        document.getElementById(zavrziid).innerHTML = "Prijatelj odstranjen";
        location.reload("UserProfile.html");
    }
    })
    
})

$('.delite-blog').on('click', function(){ //Gumb za izbris bloga
    izbrisid = $(this).prop('id');
    
    $.ajax({
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'deliteBlog', deliteBlogId: izbrisid},
        success: function(data){
            console.log(izbrisid);
            location.reload("UserProfile.html");
        }
    })
})

$('.edit-blog').on('click', function(){ //gum za urejanje bloga
    
    editblog = $(this).prop('id');
    
    
    var modal2 = document.getElementById("myModal2");
    var span2 = document.getElementsByClassName("close2")[0];
    modal2.style.display = "block";
    
    span2.onclick = function () {
	   modal2.style.display = "none";
    }
    window.onclick = function (event) {
	   if (event.target == modal2) {
		  modal2.style.display = "none";
	   }
    }
     $.ajax({
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'editBlog', editBlogId: editblog},
        success: function(data){
            
            tinymce.get("mytextareaedit").setContent(data);
            console.log(editblog);
            $("#mytextareaedit").attr("name", editblog);
    }
    })
      
})


$("#objaviedit").on('click', function(){ //objava urejenega bloga nazaj... Ga prepiše...
    idEdit = $("#mytextareaedit").prop('name');
    content = tinymce.get("mytextareaedit").getContent();
    console.log(idEdit);
    console.log(content);
    
    $.ajax({
        type: "POST",
        url: 'inc/friendrequest.php',
        data: {action: 'objaviEditBlog', editidb: idEdit, spremembe: content},
        success: function(data){
            console.log("zamenjano");
            //console.log(data);
            window.location.reload();
        }
        
    })
    
})



//TINYMCE EDITOR 
console.log("pri tinymce")
tinymce.init({
	selector: '#mytextarea', //ID textareea 
	plugins: [
    'advlist autolink link image lists charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
    'table emoticons template paste help imagetools wordcount'
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
  	//images_upload_base_path: 'img/',
  	images_upload_handler: imageHandler,
    height: "100%"
		
	


});

//TINYMCE ZA EDIT BUTTON
tinymce.init({
	selector: '#mytextareaedit', //ID textareea 
	plugins: [
    'advlist autolink link image lists charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks code fullscreen insertdatetime media nonbreaking',
    'table emoticons template paste help imagetools wordcount'
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
  	//images_upload_base_path: 'img/',
  	images_upload_handler: imageHandler,
    height: "100%"
		
});
