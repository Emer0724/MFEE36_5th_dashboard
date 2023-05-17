<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>登入</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" />
  <style>
    .bg {
      box-shadow: 5px 5px 5px gray;
      border-radius: 10px;
      padding: 50px;
    }

    #infoBar {
      /* height: 20px;
      width: 100%; */
      display: none;
    }
  </style>
</head>

<body>
  <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"> Book書易 </a>
    </div>
  </nav>
  <div class="container">
    <div class="col-4 my-5 bg">
      <form name="form1" onsubmit="checkfrom(event)">
        <h2>會員登入</h2>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" data-required="1" name="email" />
          <div id="emailHelp" class="form-text"></div>
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" data-required="1" name="password" />
          <div id="emailHelp" class="form-text"></div>
        </div>
        <div id="infoBar" class="alert alert-danger"></div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const nameField = document.querySelector("#name");
    const fields = document.querySelectorAll('form *[data-required="1"]');
    const infoBar = document.querySelector("#infoBar");

    function checkfrom(event) {
      event.preventDefault();

      for (let f of fields) {
        f.style.border = "1px solid #CCC";
        f.nextElementSibling.innerHTML = "";
      }

      let isPass = true;

      for (let f of fields) {
        if (!f.value) {
          isPass = false;
          f.style.border = "1px solid red";
          f.nextElementSibling.innerHTML = "請填入資料";
        }
      }

      if (isPass) {
        const fd = new FormData(document.form1);
        //const usp = new URLSearchParams(fb);
        // console.log(usp.toString())
        fetch("used_login-api.php", {
            method: "POST",
            body: fd,
          })
          .then((r) => r.json())
          .then((obj) => {
            console.log(obj);
            if (obj.success) {
              infoBar.classList.remove("alert-danger");
              infoBar.classList.add("alert-success");
              infoBar.innerHTML = "登入成功";
              infoBar.style.display = "block";
              setTimeout(() => {
                location.href = "used_add.php";
              }, 2000);
            } else {
              infoBar.classList.remove("alert-success");
              infoBar.classList.add("alert-danger");
              infoBar.innerHTML = "登入失敗";
              infoBar.style.display = "block";
            }
            setTimeout(() => {
              infoBar.style.display = "none";
            }, 2000);
          })
          .catch((ex) => {
            console.log(ex);
            infoBar.classList.remove("alert-success");
            infoBar.classList.add("alert-danger");
            infoBar.innerHTML = "發生錯誤";
            infoBar.style.display = "block";
            setTimeout(() => {
              infoBar.style.display = "none";
            }, 2000);
          });
      }
    }
  </script>
</body>

</html>