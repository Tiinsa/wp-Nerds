<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'wp-Nerds');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'eR1BAlsam4IJ6m>dnOK7 Npn<-c.*&MhWa:s!%;yX7M9D~ P0j;h&#o|5Oc*yI3m');
define('SECURE_AUTH_KEY',  'CbPsk`?1C9*znviEsq>X9_:H./BlYGR1R^Oo#)B6x5L ]#{N`THb_D[3jl|`5`yK');
define('LOGGED_IN_KEY',    '!b*PhE=#uxyJKv>+}Qx**m<*%kP*-.ThWB~vb1bj7vw;?5&7<3mp[7DI@&8D?;W ');
define('NONCE_KEY',        '}{d]ij4S.@i ?# VIhkB.}mD58@21N957BXD%P~%E4[[o~nlT)bG#eo8C{,5g]j*');
define('AUTH_SALT',        'loNh[BAVJXa,72|QacmsFUFizE! :SPG:&:+zH`P2G(Si3%o)}8_{at%]Qsi-_FT');
define('SECURE_AUTH_SALT', '|XYK9DKA7m1@P+3L|;Yd<_,dyHi>3(1}!NunsYPY:@+h/8iQ2ovJWG8ezJ.(M:M<');
define('LOGGED_IN_SALT',   '9=9ft8x1foB`%cb:jAvg_RU|Mknn,17,Asct0XegsYdqKzLb;LAd;K:S+/+O|; /');
define('NONCE_SALT',       'DpwN,K7pb7<K5Hn.#SGG<Y4pwOgICzg^MGu*n6]2J0`Ut]C&0|s.GnWMi{L8<TTa');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', true);
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');

