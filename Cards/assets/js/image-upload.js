$(document).ready(function (e) {
    $('.ImageUploadAJAX').bind('submit', function(e) {
        e.preventDefault(); 
        var formData = new FormData(this);
	var form = this;

        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
		var field = $(".ImageBrowse[form="+form.id+"]");
		field.val('');
		field.attr('name', '');
		field.attr('form', '');
		if(data.success === true) {
			field.next(".ImageReturn").attr('value', data.message);
			field.siblings(".ImageDisplay").attr('src', url + data.message);
		} else {
			alert(data.message);
			field.next(".ImageReturn").attr('value', '');
			field.siblings(".ImageDisplay").attr('src', '');
		}
                field.next(".ImageReturn").change();
            },
            error: function(data){
		$(".ImageBrowse[form="+form.id+"]").val('');
		$(form).children(".ImageReturn")[0].innerHTML = '';
                console.log("error");
                console.log(data);
            }
        });
    });

    $("body").on("change", ".ImageBrowse", function() {
	$(this).attr('name', 'image');
	$(".ImageBrowse.Multiple").attr('name', 'image[]');
	$(this).attr('form', $(this).attr('data-form'));
	$(this).siblings(".ImageDisplay").attr('src', url + '/assets/img/uploading.jpg');
	$(this.form).children('.extra').attr('value', $(this).attr('data-extra'));
        $(this.form).submit();
    });
});
