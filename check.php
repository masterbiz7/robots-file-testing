<div class="container">
    <?php
    require_once "header.php";

    $n = 0;
    if(!empty($_POST['URL'])) {
        $getfile = $_POST['URL'] . '/robots.txt'; // добавляем имя файла
        $file_headers = @get_headers($getfile); // подготавливаем headers страницы

        if ($file_headers[0] !== 'HTTP/1.1 200 OK') {
            $robots_present = "Файл robots.txt отсутствует";
            $serv_response = "Программист: Файл robots.txt должны отдавать код ответа 200, иначе файл не будет 
        обрабатываться. Необходимо настроить сайт таким образом, чтобы при обращении к файлу robots.txt сервер возвращает 
        код ответа 200";
            echo 'Возникла ошибка при получении файла';
            $colored1 = "bg-danger";
            $n++;

        } else if ($file_headers[0] == 'HTTP/1.1 200 OK') {
            // открываем файл для записи
            $header_status = 'Ok';
            $colored1 = "bg-success";
            $robots_present = "Файл robots.txt присутствует";
            $serv_response = "Файл robots.txt отдаёт код ответа сервера 200";
           // echo $header_status . '<br>';
            $file = fopen('robots.txt', 'w');
            // инициализация cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $getfile);
            curl_setopt($ch, CURLOPT_FILE, $file);
            curl_exec($ch);
            fclose($file);
            curl_close($ch);

            global $resultfile; // описываем как глобальную переменную
            $resultfile = 'robots.txt'; // файл, который получили

            if (!file_exists($resultfile)) {
                // Если файл отсутвует, сообщаем ошибку
                //echo "Ошибка обработки файла: $resultfile";
                $colored2 = "bg-danger";
                $n++;

            } else {
                // Начинаем обрабатывать файл, если все прошло успешно
                // $file_arr = file("robots.txt");
                $textget = file_get_contents($resultfile);
                htmlspecialchars($textget); // при желании, можно вывести на экран через echo

                if( substr_count($textget, "Host") == 1 ) {
                    $num_host_cond = "В файле прописана 1 директива Host";
                    $host_present = "Директива Host указана";
                    $host_recommend = "Доработки не требуются";
                    $host = "Ok";
                    $colored2 = "bg-success";
                } else if( substr_count($textget, "Host") > 1 ){
                    $num_host_cond = "В файле прописано несколько директив Host";
                    $host_recommend = "Программист: Директива Host должна быть указана в файле толоко 1 раз. 
                Необходимо удалить все дополнительные директивы Host и оставить только 1, корректную и соответствующую 
                основному зеркалу сайта";
                    $colored2 = "bg-danger";
                } else {
                    $num_host_cond = "В файле отсутствует директива Host";
                    $host = "Ошибка";
                    $host_present = "В файле robots.txt не указана директива Host";
                    $host_recommend = "Программист: Для того, чтобы поисковые системы знали, какая версия сайта является 
                основных зеркалом, необходимо прописать адрес основного зеркала в директиве Host. В данный момент это 
                не прописано. Необходимо добавить в файл robots.txt директиву Host. Директива Host задётся в файле 1 раз, 
                после всех правил.";
                    $colored2 = "bg-danger";
                }
                $improvements = "Доработки не требуются";
                if (preg_match("/Host/", $textget)) {
                   // echo "Директива Host есть";
                    $colored2 = "bg-success";
                    $host = "Ok";
                    $n++;
                } else {
                    //echo "Проверка невозможна, так как директива Host отсутствует!";
                    $robots_present = "Файл robots.txt присутствует, но не содержит директивы Host";
                    $host = "Ошибка";
                    $colored2 = "bg-danger";
                    $n++;
                }

                if (preg_match("/Sitemap/", $textget)) {
                    //echo "<br>"."Директива Sitemap есть";
                    $sitemap = "Ok";
                    $colored_smap = "bg-success";
                    $sitemap_present = "Директива Sitemap указана";
                    $sitemap_improvements = "Доработки не требуются";
                    $n++;
                } else {
                    //echo "<br>"."Проверка невозможна, так как директива Sitemap отсутствует!";
                    $sitemap = "Ошибка";
                    $colored_smap = "bg-danger";
                    $sitemap_present = "В файле robots.txt не указана директива Sitemap";
                    $sitemap_improvements = "Программист: добавить в файл robots.txt директиву Sitemap";
                    $n++;
                }

               // echo '<br>'.'Размер файла ' . $resultfile . ': ' . filesize($resultfile) . ' байт';
                $fsize = filesize($resultfile)<32768? "Ok":"Ошибка";
                if(filesize($resultfile)<32768) {$colored_fs = "bg-success";} else {$colored_fs = "bg-danger";}
                $fsize_condition = filesize($resultfile) < 32768 ? "Размер файла robots.txt составляет ". filesize($resultfile)." байт 
            что находится в пределах допустимой нормы": "Размер файла robots.txt составляет". filesize($resultfile).", 
            что превышает допустимую норму";
                $fsize_recommend = $fsize < 32768 ? "Доработки не требуются" :"Программист: Максимально допустимый размер файла robots.txt 
            составляет 32 кб. Необходимо отредактировть файл robots.txt таким образом, чтобы его размер не превышал 32 Кб";
            }
        }
    }

    ?>
</div>
<div class="container d-flex justify-content-center">
    <div class="row text-center mt-5">
        <a class="text-center" href='index.php'>Вернуться на главную</a>
    </div>
</div>
<br><br>
<div class="container">
    <div class="row table-responsive-md">
        <table class="table table-hover" border = "1">
            <tr>
                <th>№</th>
                <th>Название проверки</th>
                <th>Статус</th>
                <th></th>
                <th>Текущее состояние</th>
                <th></th>
            </tr>
            <tr>
                <td class="blank" colspan="6"></td>
            </tr>
            <tr>
                <td rowspan="2"><?php echo $n++; ?></td>
                <td rowspan="2">Проверка наличия файла robots.txt</td>
                <td class="<?=$colored1;?>" rowspan="2"><?=$header_status;?></td>
                <td>Состояние</td>
                <td><?php echo $robots_present;?></td>
                <td></td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td><?php echo $improvements;?></td>
                <td></td>
            </tr>
            <tr>
                <td class="blank" colspan="6"></td>
            </tr>
            <tr>
                <td rowspan="2"><?php echo $n++; ?></td>
                <td rowspan="2">Проверка указания директивы Host</td>
                <td class="<?=$colored2;?>" rowspan="2"><?=$host;?></td>
                <td>Состояние</td>
                <td><?php echo $host_present;?></td>
                <td></td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td><?=$host_recommend;?></td>
                <td></td>
            </tr>
            <tr>
                <td class="blank" colspan="6"></td>
            </tr>
            <tr>
                <td rowspan="2"><?php echo $n++; ?></td>
                <td rowspan="2">Проверка количества директив HOST, прописанных в файле</td>
                <td class="<?=$colored2;?>" rowspan="2"><?=$host;?></td>
                <td>Состояние</td>
                <td><?=$num_host_cond;?></td>
                <td></td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td><?=$improvements;?></td>
                <td></td>
            </tr>
            <tr>
                <td class="blank" colspan="6"></td>
            </tr>
            <tr>
                <td rowspan="2"><?php echo $n++; ?></td>
                <td rowspan="2">Проверка размера файла robots.txt</td>
                <td class="<?=$colored_fs;?>" rowspan="2"><?=$fsize;?></td>
                <td>Состояние</td>
                <td><?=$fsize_condition;?></td>
                <td></td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td><?=$fsize_recommend;?></td>
                <td></td>
            </tr>
            <tr>
                <td class="blank" colspan = "6"></td>
            </tr>
            <tr>
                <td rowspan="2"><?php echo $n++; ?></td>
                <td rowspan="2">Проверка указания директивы Sitemap</td>
                <td class="<?=$colored_smap;?>" rowspan="2"><?=$sitemap;?></td>
                <td>Состояние</td>
                <td><?=$sitemap_present;?></td>
                <td></td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td><?=$sitemap_improvements;?></td>
                <td></td>
            </tr>
            <tr>
                <td class="blank" colspan = "6"></td>
            </tr>
            <tr>
                <td rowspan="2"><?php echo $n++; ?></td>
                <td rowspan="2">Проверка кода ответа сервера для файла robots.txt</td>
                <td class="<?=$colored1;?>" rowspan="2"><?=$header_status;?></td>
                <td>Состояние</td>
                <td><?=$serv_response;?></td>
                <td></td>
            </tr>
            <tr>
                <td>Рекомендации</td>
                <td><?=$improvements;?></td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
<br><br><br>

</body>
</html>

