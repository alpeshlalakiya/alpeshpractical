@extends('layouts.app')
@extends('layouts.master')

@section('content')
    <div class="container">
        <button onclick="logout()" id="logout" class="btn btn-primary">Logout</button>
        <div class="row justify-content-center">
            <div class="col-md-8">

                @foreach($posts as $data)
                    <h1 class="blog-title">{{$data->title}}</h1>
                    <p class="blog-desc" id="regTitle">
                        {{$data->description}}
                    </p>
                    <img src="{{$data->image}}">
                    <button onclick="openModel({{$data->id}})">Comment</button>
                    <br>

            @endforeach



            <!-- Modal -->
                <div id="myModal" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label>Email</label><br>
                                <input placeholder="" type="text" name="email"/><br>
                                <label>Password</label><br>
                                <input placeholder="" type="password" name="password"/><br>
                                <span id="error" class="text-danger"></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="login()" id="login">Login</button>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Submit Comment -->
                    <div id="myModalComment" class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label>Enter Comment</label><br>
                                    <textarea placeholder="" type="text" name="comment"></textarea>
                                    <span id="commenterror" class="text-danger"></span>
                                </div>
                                <div class="modal-footer">
                                    <button onclick="comment()" type="button" class="btn btn-secondary" data-dismiss="modal">Add Comment</button>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript">
    var blogId;
    $(document).ready(function(){
        $("#regTitle").html();
        $("#logout").hide();

        var localStorageValue = checkLocalStorage();

        if (localStorageValue) {
            $("#logout").show();
        } else {
            $("#logout").hide();
        }
    });

    function comment() {
        event.preventDefault();

        var comment = $("textarea[name=comment]").val();
        $("#commenterror").text("");
        $.ajax({
            url: "http://127.0.0.1:8000/add-comment",
            type:"POST",
            data:{
                blog_id:blogId,
                comment : comment,
                _token: "{{ csrf_token() }}",
            },
            success:function(response){
                if(response.code == 200) {
                    $("#myModal").hide();
                    localStorage.setItem("user_obj", JSON.stringify(response.content));
                    window.location.reload();
                } else {
                    $("#commenterror").text(response.message);
                }
            },
        });
    }

    function logout() {
        localStorage.removeItem("user_obj");
        window.location.reload();
    }
    function openModel(id) {
        blogId = id;
        var localStorageValue = checkLocalStorage();

        if (localStorageValue) {
            $("#myModalComment").modal();
        } else {
            $("#myModal").modal();
        }

    }
    function checkLocalStorage() {
        var userObj = localStorage.getItem("user_obj");
        var returnVar = false;

        if (userObj != null && userObj != "" &&  typeof userObj != "undefined") {
            returnVar = true;
        } else {
            returnVar = false;
        }
        return returnVar;
    }

    function login() {
        event.preventDefault();

        var email = $("input[name=email]").val();
        var password = $("input[name=password]").val();
        $("#error").text("");
        $.ajax({
            url: "http://127.0.0.1:8000/login-new",
            type:"POST",
            data:{
                email:email,
                password:password,
                _token: "{{ csrf_token() }}",
            },
            success:function(response){
                if(response.code == 200) {
                    $("#myModal").hide();
                    localStorage.setItem("user_obj", JSON.stringify(response.content));
                    window.location.reload();
                } else {
                    $("#error").text(response.message);
                }
            },
        });
    };


</script>

<style>

    .blog-title{
        font-weight: bold;
        font-size: 24px;
    }
    .blog-desc{
        margin:0;
        padding:0;
        font-size: 16px;
        font-weight: normal;
        line-height: 24px;
    }
</style>

