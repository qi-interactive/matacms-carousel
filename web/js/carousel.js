$(window).ready(function() {


    $(document).on('click', '#add-media, .edit-media', function() {
        return false;
    });

    $('#media-modal').on('show.bs.modal', function (e) {
        var triggerEl = $(e.relatedTarget);
        var url = triggerEl.attr("data-url");
        var title = triggerEl.attr("data-title");
        var modalBody = $(this).find(".modal-body");
        
        $(this).find(".modal-header h3").text(title);

        modalBody.html(modalBody);
        $.ajax(url).done(function(data) {
            modalBody.html(data);
        });
    });

    $('#media-modal').on('hidden.bs.modal', function (e) {
        $(this).find(".modal-body script").remove();
        $(this).find(".modal-body").contents().remove();
    });

    $(document).on('click', '#media-modal #media-type-buttons a', function() {
    	var id = $(this).attr('id');
    	
    	if(id == "add-video-url-button") {
            $('#media-modal #media-type-buttons').hide();
    		$('#media-modal #add-video-url-container').show();
    	}
    	return false;
    });

    $(document).on('click', '.delete-media', function() {
        var url = $(this).attr("data-url");
        var parent = $(this).parents('li');

        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            success: function(data) {
                console.log(data.Response);
                parent.remove();
                $('.carousel-view ul.sortable').matasortable('reload');
            },
            error: function() {
                console.log(data.Response);
            }
        });
        return false;
    });

    
})