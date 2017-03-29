<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/model/MSQL.php');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>trade-meta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="backend и frontend, интеграция тем wordpress, создание плагинов wordpress, доработка сайтов, html-верстальщик, занимаюсь оптимизированной версткой и созданием сайтов">
    <meta name="keywords" content="backend, frontend, php, wordpress, javascript, доработка сайтов, html-верстальщик">
    <meta name="yandex-verification" content="2a1ace9675509622">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<!--head: Start-->
<div class="head">
    <header class="header">
        <ul>
            <li><i aria-hidden="true" class="fa fa-phone"></i><a href="skype:trademeta">Skype: trademeta</a></li>
            <li class="send-mess"><i aria-hidden="true" class="fa fa-envelope"></i><a href="#">Написать сообщение</a>
            </li>
        </ul>
    </header>
    <div class="head__logo"><a href="/"><img src="img/HTML5CSS3Logos.svg" alt=""><span class="logo-text">Качественная вёрстка сайтов. Backend и Frontend</span></a>
    </div>
</div>
<!--head: End-->
<!--slider: Start-->
<div class="slider">
    <div class="wrap">
        <div class="slick-slider">
            <div><a href="http://trade-meta.ru/works/penoboard/" target="_blank"><img src="img/penoboard.jpg" alt=""></a></div>
            <div><a href="http://trade-meta.ru/works/flex/" target="_blank"><img src="img/flex.jpg" alt=""></a></div>
            <div><a href="http://www.centrs-video.ru/" target="_blank"><img src="img/centrc.jpg" alt=""></a></div>
            <div><a href="http://trade-meta.ru/works/creativezone/" target="_blank"><img src="img/creative.png" alt=""></a>
            </div>
            <div><a href="http://trade-meta.ru/works/woofee/" target="_blank"><img src="img/woofee.jpg" alt=""></a>
            </div>
        </div>
        <div class="slider-nav"><span id="prev"><i aria-hidden="true" class="fa fa-caret-square-o-left"></i></span><span
                id="next"><i aria-hidden="true" class="fa fa-caret-square-o-right"></i></span></div>
    </div>
</div>
<!--slider: End-->
<!--layouts: Start-->
<div class="layouts">
    <div class="wrap">
        <h1>Вёрстка сайтов</h1>

        <div class="layouts__top">
            <div class="juxtapose"><img src="img/website.jpg" alt=""><img src="img/website-wb.jpg" alt=""></div>
        </div>

        <h2>Любой вид вёрстки</h2>

        <div class="layouts__content">
            <div class="outer-block"></div>
            <ul class="ul-kinds">
                <li><span class="l0">резиновая</span></li>
                <li><span class="l1">фиксированная</span></li>
                <li><span class="l2">адаптивная</span></li>
            </ul>
        </div>
    </div>
</div>
<!--layouts: End-->
<!--advantege: Start-->
<div class="advantage">
    <div class="wrap">
        <h2>Основные преимущества</h2>
        <ul>
            <li>
                <h3>PHP</h3>
                <p>Разработка php-сценариев с комментариями, применение MVC</p>
            </li>
            <li>
                <h3>MYSQL</h3>
                <p>Знание SQL, разработка таблиц, оптимизация</p>
            </li>
            <li>
                <h3>Wordpress</h3>
                <p>Разработка тем, плагинов, интеграция тем, доработка сайтов</p>
            </li>
            <li>
                <h3>Валидность</h3>
                <p>Код проверяется на валидность W3C перед сдачей работы</p>
            </li>
            <li>
                <h3>Кроссбраузерность</h3>
                <p>Сайты выглядят одинаково во всех современных браузерах</p>
            </li>
            <li>
                <h3>Соответствие макету</h3>
                <p>Сайт максимально соответствует макету, полученному от заказчика</p>
            </li>
            <li>
                <h3>Читабельность кода</h3>
                <p>Код структурирован, сопровождается комментариями для удобной поддержки сайта в будущем</p>
            </li>
            <li>
                <h3>Интерактивность</h3>
                <p>Интерактивные элементы реализуются с помощью JavaScript / jQuery</p>
            </li>
            <li>
                <h3>Адаптивность</h3>
                <p>Корректное отображение сайта на различных устройствах</p>
            </li>
        </ul>
    </div>
</div>
<!--advantege: End-->

<!--portfolio: Start-->
<?php

$msql = MSQL::Instance();
$query = "select * from works order by id desc";
$portfolio = $msql->Select($query);

?>
<div class="portfolio">
    <div class="wrap">
        <h1 class="text3d">Портфолио</h1>
        <!--book:Start-->
        <div class="book">
            <div class="hard">
                <h2 class="portf">Портфолио</h2>
                <h4 class="portf">Trade-meta</h4>
            </div>
            <?php
            foreach ($portfolio as $work): ?>
                <div class="pages1">
                    <div class="page-cont build">
                        <h3><?= $work['title'] ?></h3>

                        <p><?= $work['description'] ?></p>
                        <?php
                        $array_li = _decode($work['li']);
                        if (is_array($array_li)) {
                            $list = '<ul>';
                            foreach ($array_li as $li) {
                                $list .= '<li><p> - ' . $li . '</p></li>';
                            }
                            $list .= '</ul>';
                            echo $list;
                        }
                        if (isset($work['m_text']) && !empty($work['m_text'])) {
                            $array_text = _decode($work['m_text']);
                            if (is_array($array_text)) {
                                $m_text = '';
                                foreach ($array_text as $text) {
                                    $m_text .= '<p>' . $text . '</p>';
                                }
                            }
                            $array_img = _decode($work['m_img']);
                            if (is_array($array_img)) {
                                $m_img = '';
                                foreach ($array_img as $img) {
                                    $m_img .= '<div><img src="img/' . $img . '" alt=""></div>';
                                }
                            }
                            ?>
                            <a href="#" class="more">Подробнее</a>

                            <div class="more-block">
                                <div>
                                    <?php echo $m_text; ?>
                                </div>
                                <?php
                                if (isset($work['m_img']) && !empty($work['m_img']) && $m_img) {
                                    echo $m_img;
                                } ?>
                            </div>
                        <?php } ?>
                        <a href="<?= $work['link'] ?>" target="_blank" class="moblink"><span>Перейти на сайт</span></a>
                        <?php if(!empty($work['github'])): ?>
                            <a href="<?= $work['github'] ?>" target="_blank" class="github"><span>Перейти в gitHub</span></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="pages"><img src="<?php echo 'img/'. $work['image'] ?>" alt=""></div>
            <?php endforeach; ?>

            <div class="pages1 last">
                <div class="page-cont">
                    <h5 class="elegantshadow">Trade-meta</h5>
                </div>
            </div>
            <div class="pages last">
                <div class="page-cont">
                    <button data-text="Заказать сайт" class="order">
                        <span>З</span><span>а</span><span>к</span><span>а</span><span>з</span><span>а</span><span>т</span><span>ь</span><span> </span><span>с</span><span>а</span><span>й</span><span>т</span>
                    </button>
                </div>
            </div>
            <div class="pages1 hard">
                <div class="page-cont">
                    <h2 class="portf">С уважением</h2>

                    <h2 class="portf">Trade-meta</h2>
                </div>
            </div>
        </div>
        <div class="book-left"><i aria-hidden="true" class="fa fa-hand-o-left"></i></div>
        <div class="book-right"><i aria-hidden="true" class="fa fa-hand-o-right"></i></div>
        <!--book: End-->

        <!--nobook: Start-->
        <div class="nobook">
            <?php
            foreach ($portfolio as $work): ?>
                <div class="pages">
                    <img src="<?php echo 'img/'. $work['image'] ?>" alt="">
                    <div class="pages1">
                        <div class="page-cont">
                            <h3><?= $work['title'] ?></h3>

                            <p><?= $work['description'] ?></p>
                            <?php
                            $array_li = _decode($work['li']);
                            if (is_array($array_li)) {
                                $list = '<ul>';
                                foreach ($array_li as $li) {
                                    $list .= '<li><p> - ' . $li . '</p></li>';
                                }
                                $list .= '</ul>';
                                echo $list;
                            }
                            if (isset($work['m_text']) && !empty($work['m_text'])) {
                                $array_text = _decode($work['m_text']);
                                if (is_array($array_text)) {
                                    $m_text = '';
                                    foreach ($array_text as $text) {
                                        $m_text .= '<p>' . $text . '</p>';
                                    }
                                }
                                $array_img = _decode($work['m_img']);
                                if (is_array($array_img)) {
                                    $m_img = '';
                                    foreach ($array_img as $img) {
                                        $m_img .= '<div><img src="img/' . $img . '" alt=""></div>';
                                    }
                                }
                                ?>
                                <a href="#" class="more">Подробнее</a>

                                <div class="more-block">
                                    <div>
                                        <?php echo $m_text; ?>
                                    </div>
                                    <?php
                                    if (isset($work['m_img']) && !empty($work['m_img']) && $m_img) {
                                        echo $m_img;
                                    } ?>
                                </div>
                            <?php } ?>
                            <a href="<?= $work['link'] ?>" target="_blank" class="moblink"><span>Перейти на сайт</span></a>
                            <?php if(!empty($work['github'])): ?>
                                <a href="<?= $work['github'] ?>" target="_blank" class="github"><span>Перейти в gitHub</span></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!--nobook: End-->
    </div>
</div>
<!--portfolio: End-->

<!--form-block: Start-->
<div class="form-block">
    <div class="wrap">
        <h2>Обратная связь</h2>

        <form action="#" class="form">
            <ul>
                <li>
                    <input type="text" placeholder="Имя" id="name" name="name" title="Минимум 3 символа"><span
                        class="error"></span>
                </li>
                <li>
                    <input type="email" placeholder="E-mail" id="email" name="email" title="Некорректный e-mail"><span
                        class="error"></span>
                </li>
                <li>
                    <textarea id="textarea" name="textarea" placeholder="Сообщение" title="Мин. 10 символов"></textarea><span
                        class="error"></span>
                </li>
                <li>
                    <input type="submit" value="Отправить" class="submit">
                </li>
            </ul>
        </form>
    </div>
</div>
<!--form-block: End-->

<!--footer: Start-->
<div class="footer-block">
    <div class="wrap">
        <footer>
            <p>© 2017 Trade-meta.<span class="azeroth"> Web-разработка.</span></p>

            <p><a href="skype:trademeta">Skype: trademeta</a></p>

            <p><a href="mailto:trade-meta@mail.ru">E-mail: trade-meta@mail.ru</a></p>

            <div class="trademeta azeroth" title="Вверх"><span>Trade-meta</span></div>
        </footer>
    </div>
</div>
<!--footer: End-->

<a href="#menu" class="menu-link"><span></span></a>
<nav id="menu">
    <ul>
        <li><a href="#" data-link="advantage">Преимущества</a></li>
        <li><a href="#" data-link="portfolio">Портфолио</a></li>
        <li><a href="#" data-link="form-block">Обратная связь</a></li>
        <li><a href="#" class="change-view" title="Поменять внешний вид блока с работами">Внешний вид портфолио</a></li>
    </ul>
</nav>
<!--Submit message - popup-->
<div class="popup">
    <div class="popup__overlay"></div>
    <div class="popup__before"></div>
    <div class="popup__content"></div>
</div>

<script src="js/script.js"></script>
</body>
</html>