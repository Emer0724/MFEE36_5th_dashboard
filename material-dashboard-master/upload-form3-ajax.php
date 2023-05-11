<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button onclick="selectFile()">上傳</button>


    <form name="form1" style="display: none">
        <input type="file" name="avatar" id="avatar" accept="image/jpeg">

    </form>

    <img src="" alt="" id="myimg">
    <script>
        const inp_avatar = document.querySelector('#avatar');
        inp_avatar.addEventListener('change', function(event) {
            const fd = new FormData(document.form1);

            fetch('upload-test03.php', {
                    method: 'POST',
                    body: fd
                }).then(r => r.json())
                .then(obj => {
                    if (obj.filename) {
                        document.querySelector('#myimg').src = './imgs/' + obj.filename;
                    }
                })
                .catch(ex => {
                    console.log(ex);
                })
        });

        function selectFile() {
            inp_avatar.click(); // 模擬點擊
        }
    </script>
</body>

</html>