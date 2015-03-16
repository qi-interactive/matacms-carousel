$(window).ready(function() {


    $(document).on('click', '#add-media, .edit-media', function() {
        return false;
    });

    $('#edit-media-modal').on('show.bs.modal', function (e) {
        var triggerEl = $(e.relatedTarget);
        var url = triggerEl.attr("data-url");
        var modalBody = $(this).find(".modal-body");
        modalBody.html(modalBody);
        $.ajax(url).done(function(data) {
            modalBody.html(data);
        });
    });

    $('#add-media-modal #media-type-buttons a').on('click', function() {
    	var id = $(this).attr('id');
    	$('#add-media-modal #media-type-buttons').hide();
    	if(id == "add-image-button") {
    		$('#add-media-modal #upload-image-container').show();
    	}
    	else {
    		$('#add-media-modal #add-video-url-container').show();
    	}
    	return false;
    });

    $('#add-media-modal').on('hide.bs.modal', function () {
    	$('#media-type-buttons', this).show();
        $('#add-video-url-container form')[0].reset();
        $('.video-preview-container').empty();
        $('#upload-image-container, #add-video-url-container', this).hide();
    });

    $('#edit-media-modal').on('hide.bs.modal', function () {
        $('.video-preview-container').empty();
    	// $('#media-type-buttons', this).show();
    	// $('#upload-image-container, #add-video-url-container', this).hide();
    });
})