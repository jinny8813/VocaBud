<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LetsgoVoc</title>
    <link rel="shortcut icon" href="<?= base_url('../../public/assets/images/icon.png') ?>" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= base_url('../../public/assets/css/style.css') ?>" />
</head>
<body class="font-monospace">

<section class="min-vh-100 bg_dark">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center py-5 my-5">
            <div class="py-5 my-5" id="myTitle">
                <h1 class="text-center mt-5 pt-5" style="color:white">LetsgoVoc</h1>
                <p class="text-center" style="color:white">Let's enjoy learning in an efficient way.</p>
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary m-2 toLogin">登入</a>
                    <a class="btn btn-primary m-2 toRegister">註冊</a>
                </div>
            </div>

            <div class="col-md-8 my-3 d-none" id="isLogin">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center fs-3 mb-3">登入</div>
                        <form id="loginForm">
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="email" class="form-label">電子信箱</label>
                                </div>
                                <div class="col-9">
                                    <input type="email" name="email" class="form-control" placeholder="請輸入電子信箱" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="password" class="form-label">密碼</label>
                                </div>
                                <div class="col-9">
                                    <input type="password" name="password" class="form-control" placeholder="請輸入密碼" required>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn">送出</button>
                            </div>
                        </form>
                        <div class="alert alert-danger text-center my-3 py-3 d-none" id="errorL">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 my-3 d-none" id="isRegister">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center fs-3 mb-3">註冊</div>
                        <form id="registerForm">
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="email" class="form-label">電子信箱</label>
                                </div>
                                <div class="col-9">
                                    <input type="email" name="email" class="form-control" placeholder="請輸入電子信箱" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="password" class="form-label">密碼</label>
                                </div>
                                <div class="col-9">
                                    <input type="password" name="password" class="form-control" placeholder="請輸入密碼" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="cpassword" class="form-label">密碼驗證</label>
                                </div>
                                <div class="col-9">
                                    <input type="password" name="cpassword" class="form-control" placeholder="密碼驗證" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-3">
                                    <label for="nickname" class="form-label">暱稱</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="nickname" class="form-control" placeholder="請輸入密碼" required>
                                </div>
                            </div>
                            <div class="form-group d-flex justify-content-center">
                                <button type="submit" name="submit" class="btn btn-primary">送出</button>
                            </div>
                        </form>
                        <div class="alert alert-danger text-center my-3 py-3 d-none" id="errorR">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 my-3 d-none" id="istoRegister">
                <div class="card">
                    <div class="card-body">
                        <p class="text-center">還沒有帳號嗎?現在就註冊一個吧!</p>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary toRegister">註冊</a>
                        </div>
                    </div>
                </div>    
            </div>

            <div class="col-md-8 my-3 d-none" id="istoLogin">
                <div class="card">
                    <div class="card-body">
                        <p class="text-center">已經有帳號!!回到登入頁面</p>
                        <div class="d-flex justify-content-center">
                            <a class="btn btn-primary toLogin">登入</a>
                        </div>
                    </div>
                </div>    
            </div>

        </div>
        
    </div>
</section>
<script>
    let myTitle = document.getElementById("myTitle");
    let isLogin = document.getElementById("isLogin");
    let isRegister = document.getElementById("isRegister");
    let istoLogin = document.getElementById("istoLogin");
    let istoRegister = document.getElementById("istoRegister");

    document.querySelectorAll(".toRegister").forEach(element => 
        element.addEventListener("click",(e) => {
            isRegister.classList.remove('d-none');
            istoLogin.classList.remove('d-none');
            isLogin.classList.add('d-none');
            istoRegister.classList.add('d-none');
            myTitle.classList.add('d-none');
      }))
    
    document.querySelectorAll(".toLogin").forEach(element => 
        element.addEventListener("click",(e) => {
            isLogin.classList.remove('d-none');
            istoRegister.classList.remove('d-none');
            isRegister.classList.add('d-none');
            istoLogin.classList.add('d-none');
            myTitle.classList.add('d-none');
      }))

    let loginForm = document.getElementById("loginForm");
    let errorL = document.getElementById("errorL");

    loginForm.addEventListener("submit",(e) => {
        e.preventDefault();
        errorL.classList.add('d-none');
        let formdata= new FormData(loginForm);
        myLib1.POST("<?= base_url('/login') ?>",formdata);
    })

    let myLib1 = {
    POST: (url,formdata) => {
        axios.post(url,formdata)
        .then((response) => {
            window.location.href = `<?= base_url('/home')?>`;
        }).catch((e) => {
            errorL.innerHTML = JSON.stringify(e.response.data);
            errorL.classList.remove("d-none");
            console.log(e.response.data);
        })
    },
    }

    let registerForm = document.getElementById("registerForm");
    let errorR = document.getElementById("errorR");

    registerForm.addEventListener("submit",(e) => {
        e.preventDefault();
        errorR.classList.add('d-none');
        formdata= new FormData(registerForm);
        myLib2.POST("<?= base_url('/register') ?>",formdata);
    })

    let myLib2 = {
    POST: (url,formdata) => {
        axios.post(url,formdata)
        .then((response) => {
            window.location.href = `<?= base_url('/')?>`;
        }).catch((e) => {
            errorR.innerHTML = JSON.stringify(e.response.data);
            errorR.classList.remove("d-none");
            console.log(e.response.data);
        })
    },
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js" integrity="sha512-uMtXmF28A2Ab/JJO2t/vYhlaa/3ahUOgj1Zf27M5rOo8/+fcTUVH0/E0ll68njmjrLqOBjXM3V9NiPFL5ywWPQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>