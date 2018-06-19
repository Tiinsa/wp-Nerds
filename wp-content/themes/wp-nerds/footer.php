        <footer class="main-footer">
          
                <div class="footer-maps <?php if( is_customize_preview() ){ echo 'footer-maps__preview';} ?>">
                <?php
                    if( is_customize_preview() ){
                        echo "<button class='btn_map btn_map--map' type='submit' value=''>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z'></path></svg>
                        </button>";
                    }
                ?>
                    <div class="map-script"></div>
                    <div class="conteiner ">
                        <section class="footer-contacts">
                            <b>Nёrds design studio</b>
                            <p>181186, Санкт-Петербург,<br>
                                улица Б. Конюшенная, д. 19/8
                            </p>
                            <p>тел. +7 (812) 275-75-75</p>
                            <a class="btn" href="#">Напишите нам</a>
                        </section>
                    </div>
                </div>



            <div class="conteiner clearfix">
                <section class="footer-social">
                    <a class="social-btn social-btn-vk" href="#">Вконтакте</a>
                    <a class="social-btn social-btn-fb" href="#">Фейсбук</a>
                    <a class="social-btn social-btn-inst" href="#">Инстаграм</a>
                </section>
                <div class="footer-notes">
                    <p>Давайте дружить, это выгодно!</p>
                    <p>Скидка 10% для друзей из социальных сетей.</p>
                </div>
            </div>
        </footer>
        <div class="feedback">
            <form method="post">
                <div class="feedback-user clearfix">
                    <div class="feedback-left">
                        <label class="feedback-data" for="feedback-login">Ваше имя:</label>
                        <input type="text" name="login" id="feedback-login" placeholder="Представьтесь, пожалуйста" ><!-- required -->
                    </div>
                    <div class="feedback-right">
                        <label class="feedback-data" for="feedback-email">Ваш e-mail:</label>
                        <input type="email" name="email" id="feedback-email" placeholder="Для отправки ответа" ><!-- required -->
                    </div>
                </div>
                <label class="feedback-data" for="feedback-textarea">Текст письма:</label>
                <textarea name="text" id="feedback-textarea" placeholder="В свободной форме" rows="5"></textarea>
                <button type="submit" class="btn feedback-btn">Отправить</button>
                <a href="#" class="btn feedback-circle-btn"></a>
            </form>
        </div>
        

        <?php wp_footer(); ?>
        <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3&key=AIzaSyAOelhnqKXLp86XJrRuvflHNKuiKv8fMYs"></script> -->
        <!-- <script src="/js/script.js"></script> -->
    </body>
</html>