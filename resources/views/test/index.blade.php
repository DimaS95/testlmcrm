@extends('layouts.app')

@section('content')

    <table style="width:50%">
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Icon</th>
                </tr>
                @foreach($leads as $lead)
                    <tr id = "{{$lead->id}}";>

                        <td>{{$lead->date}}</td>
                        <td>{{$lead->name}}</td>
                        <td>{{$lead->email}}</td>
                        <td>{{$lead->phone}}</td>
                    </tr>
                 @endforeach
        <br/>
        <br/>
    </table>
        <table style="width:20%">

            <tr>
                <th>icon</th>
                <td></td>
            </tr>
            <tr>
                <th>date</th>
                <td id = "date"></td>
            </tr>
            <tr>
                <th>name</th>
                <td id = "name"></td>
            </tr>
            <tr>
                <th>phone</th>
                <td id = "phone"></td>
            </tr>
            <tr>
                <th id = "radio"></th>
                <td id = "radioValue"></td>
            </tr>
            <tr>
                <th id = "checkbox"></th>
                <td id = "checkValue"></td>
            </tr>
        </table>

    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {
            $("tr").click(function () {
                id = $(this).attr('id');
                console.log(id);
                $.ajax({
                    type: 'GET',
                    url: '/lead/' + id,
                    data: '_token = <?php echo csrf_token() ?>',
                    success: function (data) {
                        console.log(data);
                        //alert(data[0].name);

                        if (!data) alert('no details given');

                        $("#name").html(data[0].name);
                        $("#date").html(data[0].date);
                        $("#phone").html(data[0].phone);
                        $("#radio").html(data[0].label);
                        $("#checkbox").html(data[1].label);
                        $("#radioValue").html(data[0].value);
                        $("#checkValue").html(data[1].value);

                    }
                });
            })


        });

    </script>

@endsection