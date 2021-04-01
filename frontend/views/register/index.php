<section class="registration__user">
    <h1>Регистрация аккаунта</h1>
    <div class="registration-wrapper">
        <form class="registration__user-form form-create">
            <div class="field-container field-container--registration has-error">
                <label for="16">Электронная почта</label>
                <input class="input textarea" type="email" id="16" name="" placeholder="kumarm@mail.ru">
                <span class="registration__text-error">Введите валидный адрес электронной почты</span>
            </div>
            <div class="field-container field-container--registration">
                <label for="17">Ваше имя</label>
                <input class="input textarea" type="text" id="17" name="" placeholder="Мамедов Кумар">
                <span class="registration__text-error">Введите ваше имя и фамилию</span>
            </div>
            <div class="field-container field-container--registration">
                <label for="18">Город проживания</label>
                <select id="18" class="multiple-select input town-select registration-town" size="1" name="town[]">
                    <option value="Moscow">Москва</option>
                    <option selected value="SPB">Санкт-Петербург</option>
                    <option value="Krasnodar">Краснодар</option>
                    <option value="Irkutsk">Иркутск</option>
                    <option value="Bladivostok">Владивосток</option>
                </select>
                <span class="registration__text-error">Укажите город, чтобы находить подходящие задачи</span>
            </div>
            <div class="field-container field-container--registration">
                <label class="input-danger" for="19">Пароль</label>
                <input class="input textarea " type="password" id="19" name="">
                <span class="registration__text-error">Длина пароля от 8 символов</span>
            </div>
            <a href="account.html" class="button button__registration" type="submit">Cоздать аккаунт</a>
        </form>
    </div>
</section>