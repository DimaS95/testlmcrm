$(document).ready(function(){

   // var url = "/ajax-crud/public/tasks";

    //display modal form for task editing
    /*$('#but').click(function(){
        var task_id = $(this).val();

        $.get(url + '/' + task_id, function (data) {
            //success data
            console.log(data);
            $('#task_id').val(data.id);
            $('#task').val(data.task);
            $('#description').val(data.description);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        })
    });
    */
    function getData(id){
        $.ajax({
            type:'GET',
            url:'/lead/' + id,
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){
                console.log(data);
            }
        });
    }


});
