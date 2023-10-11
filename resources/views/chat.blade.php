@extends('layout.app')
@section('content')
<style>
    #message-box {
        height: 60vh !important;
        overflow-y: auto;
        display: flex;
        flex-direction: column-reverse;
    }
</style>
<div id="message-box" class="border p-3 mt-3 rounded">
</div>
<form id="messageForm">
    <div class="row mt-4">
        <input type="hidden" name="sender_id" value="{{ Auth::user()->id }}">
        <input type="hidden" id="receiver_id" name="receiver_id" value="{{ request('id') }}">

        <div class="col-sm-11 col-md-11 col-lg-11 col-9">
            <input type="text" name="content" required class="form-control" id="inputbox" placeholder="Type...">
        </div>
        <div class="col-sm-1 col-md-1 col-lg-1 col-3 px-0">
            <button type="submit" class="btn btn-dark">Send</button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        LoadChat();

        $('#messageForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            sendMessage(formData);
        });

        function sendMessage(formData) {
            $.ajax({
                url: '{{ route('send.message') }}'
                , type: 'post'
                , data: formData
                , headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                , success: function(data) {
                    LoadChat();
                    $('#messageForm')[0].reset();
                }
                , error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        setInterval(function() {
            LoadChat();
        }, 5000); // 5000 milliseconds = 5 seconds

        function LoadChat() {
            reciver_id = $('#receiver_id').val();
            $.ajax({
                url: '{{ route('load.message') }}'
                , type: 'get'
                , data: {
                    id: reciver_id
                }
                , success: function(data) {
                    $('#message-box').empty().append(data);
                }
                , error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

</script>
@endsection
