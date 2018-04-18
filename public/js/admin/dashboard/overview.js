$(function() {
	//==============
    // UTILS 
    //==============
	function parseValueInternet(){
		elm = $('.c-internet-quality-mark');
		checkPoint = elm.text();
		elm.html(FDTNetworkUtil.markToRating(parseInt(checkPoint)));
	}
	//==============
    // TABLE 
    //==============
	function configureDataTable(){

        $("#table-history").DataTable({
        	responsive: true,
            ordering: true,
            searching: true,
            responsive: true,
            filter: false,
            paging: true,
            info: false,
            buttons: [
	            'copyHtml5',
	            'excelHtml5',
	            'csvHtml5',
	            'pdfHtml5'
	        ]
        });

        $('.dataTables_wrapper .row:last .col-sm-5').prepend($('#table-history_length')); 
    }
	

	$(document).ready(function(){	
		parseValueInternet();
		configureDataTable();
	});


});

//==============
// MEDIA PLAYER
//==============
var audioElement;
function playVoice(elm){
    lastElm = elm;
    if (audioElement != undefined) {
        if (audioElement.duration > 0 && !audioElement.paused) {//---> Stop audio is playing
            audioElement.pause();
            $('.c-voice').attr('onclick','playVoice(this);');
            $('.c-voice').html('<i class="fa fa-play-circle" aria-hidden="true"></i>');
        }
    }
    //---> Create new audio and run it
    audioElement = document.createElement('audio');
    audioElement.setAttribute('src', elm.getAttribute('data'));
    audioElement.play();
    $(elm).html('<i class="fa fa-stop-circle-o" aria-hidden="true"></i>');
    $(elm).attr('onclick','stopVoice(this);');
    audioElement.addEventListener('ended', function() {
        stopVoice(elm);
    }, false);
}

function stopVoice(elm){
    audioElement.pause();
    $(elm).attr('onclick','playVoice(this);');
    $(elm).html('<i class="fa fa-play-circle" aria-hidden="true"></i>');
}


function displayImageModal(elmId){
    //---> BEGIN: Handle modal show full image
    // Get the modal
    var modal = document.getElementById('modalImageView');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById(elmId);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    modal.style.display = "block";
    modalImg.src = img.src;
    //captionText.innerHTML = userData.first_name+' '+userData.last_name;

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
        modal.style.display = "none";
    }
    modalImg.onclick = function() { 
        modal.style.display = "none";
    }
    //---> END: Handle modal show full Image
}



	