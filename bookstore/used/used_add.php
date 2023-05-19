<?php
session_start();
require '../parts/connect_db.php';
// $sql="SELECT * FROM member where sid= {$_SESSION['sid']['sid']}";
// $stmt=$pdo->query($sql)->fetch()
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @media print {
      .no-print {
        display: none;
      }
    }

    .bg {
      background-color: whitesmoke;
      box-shadow: 5px 5px 5px gray;
      border-radius: 10px;
    }

    #add_book {
      display: none;
    }

    .alert {
      width: 400px;
      height: 200px;
      position: absolute;
      top: 50%;
      transform: translate(-200px, -100px);
      left: 50%;

      z-index: 1.5;
      background-color: white;
      box-shadow: 5px 5px 10px gray;

    }

    .none {
      display: none;
    }

    .detal {
      width: 700px;
      height: 500px;
      position: absolute;
      top: 50%;
      transform: translate(-350px, -250px);
      left: 50%;

      z-index: 2;
      background-color: white;
      box-shadow: 5px 5px 10px gray;


    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary no-print">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Book書易</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../index.php">首頁</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">二手書</a>
          </li>


          <ul class="navbar-nav  mb-2 mb-lg-0 ">
            <li class="nav-item ">
              <a class="nav-link disabled text-info"><?= $_SESSION['sid']['username'] ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled text-info">登出</a>
            </li>
          </ul>
        </ul>

      </div>
    </div>
  </nav>
  <div class="container my-5 bg py-3 position-relative no-print ">
    <div class="container">
      <div class="row">
        <div class='col-7 '>
          <h3>二手書上架</h3>
          <div class=" pb-5 ms-5">
            <form name='form1'>
              <div class="mb-3 my-5">
                <label for="ISBN">ISBN:</label>
                <input type="text" id="ISBN" class="rounded-3" name="ISBN" />
                <input type="button" id="search" class="ms-3 btn btn-info" value="搜尋" />
              </div>
              <div>
                <h2 class="book_name" id="book_name"></h2>
                <div class="d-flex mt-5">
                  <img alt="暫無圖片" id="img" style="display: none" />
                  <div class="ms-5 d-flex flex-column justify-content-center">
                    <h5 id="authors"></h5>

                    <h5 id="publisher"></h5>

                    <h5 id="publishedDate"></h5>
                  </div>
                </div>


              </div>
          </div>

          </form>
        </div>
        <div class="col-5 d-flex justify-content-center align-items-center border-start ">
          <div>
            <h3 class="mb-3">會員資料確認</h3>
            <h5 class="ms-3">姓名:<?= $_SESSION['sid']['name'] ?></h5>
            <h5 class="ms-3">email:<?= $_SESSION['sid']['email'] ?></h5>
            <h5 class="ms-3">地址:<?= $_SESSION['sid']['full_address'] ?></h5>

            <a href="#" class="ms-3">修改會員資料</a>
          </div>
          <div id="add_book" class="position-absolute bottom-0 start-50 translate-middle-x mb-3">
            <p>**請確認所有資訊</p>
            <button class="btn btn-info" id='adds' preventDefault>我要上架</button>
          </div>
        </div>
      </div>

    </div>
    <div class='none' id='success'>
      <div class='alert d-flex align-items-center justify-content-center '>
        <div class=' d-flex flex-column justify-content-center align-items-center '>
          <div><i class="fa-regular fa-face-smile-wink text-success fs-1"></i></div>
          <div class=" fs-2 mt-2">上架新增成功</div>
          <div>自動跳轉中...</div>
        </div>
      </div>
    </div>
    <div class='none' id='danger'>
      <div class=' alert d-flex align-items-center justify-content-center' id='success'>
        <div class=' d-flex flex-column justify-content-center align-items-center '>
          <div><i class="fa-regular fa-face-sad-tear fs-1 text-info"></i></i></div>
          <div class=" fs-2 mt-2">上架新增失敗</div>
          <div>再接再厲!你可以的!</div>
        </div>
      </div>
    </div>
    <div class=' none' id='qun'>
      <div class='alert d-flex align-items-center  justify-content-center' id='success'>
        <div class=' d-flex flex-column justify-content-center align-items-center '>
          <div><i class="fa-solid fa-circle-exclamation fs-1 text-info"></i></div>
          <div class=" fs-2 mt-2">上架發生問題</div>
          <div>請聯絡管理人員</div>
        </div>
      </div>
    </div>

  </div>
  <div class="detal none " id='detal'>
    <div>

      <table class="table  ">
        <thead>
          <tr>
            <th scope="col" colspan="2" class='text-center fs-3'>二手書上架資訊</th>

          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row pe-3 ps-2">上架流水號</th>
            <td id='serial_id' class="ps-2"></td>
          </tr>
          <tr>
            <th scope="row pe-3 ps-2">ISBN</th>
            <td id='ISBN2' class="ps-2"></td>
          </tr>
          <tr>
            <th scope="row pe-3 ps-2">書名</th>
            <td id="name_book" class="ps-2"></td>
          </tr>
          <tr>
            <th scope="row pe-3 ps-2">會員名稱</th>
            <td id="name_member" class="ps-2"></td>
          </tr>
          <tr>
            <th scope="row pe-3 ps-2">email</th>
            <td id="email" class="ps-2"></td>
          </tr>
          <th scope="row pe-3 ps-2">地址</th>
          <td id="address" class="ps-2"></td>
          </tr>


        </tbody>






      </table>
      <p class='bottom-0 mx-3 mt-5'>**請列印上表資訊並與該二手書一同寄回 106台北市大安區復興南路一段390號2樓 </p>
      <div class="position-absolute bottom-0 end-0 me-3 mb-3 no-print">
        <button type="button" class="btn btn-primary" id="print" onclick="window.print()">列印</button>
        <button type="button" class="btn btn-secondary" id="close">關閉</button>
      </div>
    </div>



  </div> <!--100-->
  <script src="	https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let search = document.getElementById("search");
    let img = document.getElementById("img");
    let authors = document.getElementById("authors");
    let publisher = document.getElementById("publisher");
    let publishedDate = document.getElementById("publishedDate");
    let description = document.getElementById("description");
    let book_name = document.getElementById("book_name");
    let add_book = document.getElementById("add_book");
    let ISBN_input = document.getElementById('ISBN');
    let success = document.getElementById('success')
    let danger = document.getElementById('danger')
    let qun = document.getElementById('qun')
    let detal = document.getElementById('detal')
    let serial_id = document.getElementById('serial_id')
    let ISBN2 = document.getElementById('ISBN2')
    let name_book = document.getElementById('name_book')
    let email = document.getElementById('email')
    let address = document.getElementById('address')
    let name_member = document.getElementById('name_member')

    search.addEventListener("click", () => {
      let ISBN = document.getElementById("ISBN").value;
      console.log(ISBN);
      let book_info = {};
      fetch(
          `https://www.googleapis.com/books/v1/volumes?q=isbn:${ISBN}&qt=lang_switch&lang=zh-tw&country=TW`
        )
        .then((r) => {
          return r.json();
        })
        .then((rs) => {
          book_info = rs.items[0];
          book_name.textContent = `${book_info.volumeInfo.title}:${book_info.volumeInfo.subtitle}`;
          if (book_info.volumeInfo.imageLinks.smallThumbnail) {
            img.setAttribute(
              "src",
              `${book_info.volumeInfo.imageLinks.smallThumbnail}`
            );
            console.log(book_info.volumeInfo.imageLinks.smallThumbnail);
            img.style.display = "block";
          } else {
            img.setAttribute("src", "");
          }
          authors.textContent = `作者:${book_info.volumeInfo.authors}`;
          publisher.textContent = `出版社:${book_info.volumeInfo.publisher}`;
          publishedDate.textContent = `出版日期:${book_info.volumeInfo.publishedDate}`;
          // description.textContent = `${book_info.volumeInfo.description}`;
          add_book.style.display = "block";
        })
        .catch((error) => {
          console.log(`Error: ${error}`);
        });

    });
    let adds = document.getElementById('adds')
    adds.addEventListener('click', (event) => {
      let ISBN = document.getElementById("ISBN").value;
      event.preventDefault();
      let isPass = true;
      if (ISBN == '') {

        isPass = false
        ISBN_input.style.border = '1px solid red';
        ISBN_input.ariaPlaceholder = '請輸入ISBN';
      }
      re = /^\d{13,}$/
      if (!re.test(ISBN)) {
        ISBN_input.style.border = '1px solid red';
        ISBN_input.ariaPlaceholder = 'ISBN格式錯誤';
        isPass = false
      }
      if (isPass) {
        const fd = new FormData(document.form1)
        fetch('used_add_api.php', {
          method: 'POST',
          body: fd,

        }).then(r => r.json()).then(
          obj => {
            console.log(obj);
            if (obj.success) {
              success.style.display = 'block'
              setTimeout(() => {
                success.style.display = 'none'
                detal.style.display = 'block'
                serial_id.textContent = `${obj.detal.serial_id}`
                ISBN2.textContent = `${obj.detal.ISBN}`
                name_book.textContent = `${obj.detal.book_name}`
                email.textContent = `${obj.detal.email}`
                address.textContent = `${obj.detal.full_address}`
                name_member.textContent = `${obj.detal.name_member}`
              }, 2000)


            } else {
              danger.style.display = 'block'
              setTimeout(() => {
                danger.style.display = 'none'



              }, 2000)
            }
          }
        ).catch(ex => {
          console.log(ex);
          qun.style.display = 'block'
          setTimeout(() => {
            qun.style.display = 'none'
          }, 2000)

        })

      }

    })
    let close = document.getElementById('close');
    close.addEventListener('click', () => {
      detal.style.display = 'none'
    })
  </script>
</body>

</html>