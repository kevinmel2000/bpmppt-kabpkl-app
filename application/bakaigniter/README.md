# Baka Igniter 0.1.4

Yet another Codeigniter Started Package that used on my projects and licensed under [DBAD-license](http://dbad-license.org).

## Authors

**[Fery Wardiyanto](http://github.com/feryardiant)**

### Structure of Baka Igniter

```
bakaigniter/
├─ config
│  └─ bakaigniter.php
├─ helpers
│  ├─ baka_array_helper.php
│  ├─ baka_asssets_helper.php
│  ├─ baka_authr_helper.php
│  ├─ baka_common_helper.php
│  ├─ baka_data_helper.php
│  ├─ baka_emailer_helper.php
│  ├─ baka_former_helper.php
│  ├─ baka_recaptcha_helper.php
│  ├─ baka_themee_helper.php
│  └─ baka_twbs_helper.php
├─ language
│  └─ indonesian
│      └─ bakaigniter_lang.php
├─ libraries
│  ├─ Archive
│  │  ├─ Archive.php
│  │  └─ drivers
│  │     └─ Archive_zip.php
│  ├─ Authr
│  │  ├─ Authr.php
│  │  └─ drivers
│  │     ├─ Authr_autologin.php
│  │     ├─ Authr_login_attempt.php
│  │     ├─ Authr_permissions.php
│  │     ├─ Authr_role_perms.php
│  │     ├─ Authr_roles.php
│  │     ├─ Authr_user_log.php
│  │     ├─ Authr_user_meta.php
│  │     ├─ Authr_user_perms.php
│  │     ├─ Authr_user_roles.php
│  │     └─ Authr_users.php
│  ├─ Asssets.php
│  ├─ Former.php
│  ├─ Gridr.php
│  ├─ Ignite.php
│  ├─ Median.php
│  ├─ Messg.php
│  ├─ Setting.php
│  ├─ Themee.php
│  └─ Utily.php
└─ samples
    ├─ config
    │  ├─ autoload.php
    │  └─ constants.php
    └─ libraries
    │   └─ BAKA_Form_validation.php
    └─ database.sql

```

## Installation

1. **I'm assuming** youre on your CI root path, if not:

   ```bash
   $ cd path/to/your/ci-project
   ```

2. **Download it**

   * **Download using wget** archive of this repo and extract it:

     ```bash
     $ wget https://github.com/feryardiant/bakaigniter/archive/master.tar.gz -O - | tar xz
     ```

   * **Download using curl** archive of this repo and extract it:

     ```bash
     $ curl -L https://github.com/feryardiant/bakaigniter/archive/master.tar.gz | tar xz
     ```

3. **Import sample tables** from `samples/database.sql` into your database:

   ```bash
   $ cd bakaigniter
   $ mysql -u{username} [-p{password}] {database} < samples/database.sql
   ```

   **Note:** change `{username}`, `{password}` and `{database}` with your own.

4. **Recognise it** by edit `APPPATH/config/autoload.php` file:

   ```php
   $autoload['packages'] = array(APPPATH.'third_party/bakaigniter');
   ```

5. **Autoload nessesary files**:

   ```php
   // Libraries
   // if you want to autoload BakaIgniter package, make sure to
   // autoload Database before Ignite class
   $autoload['libraries'] = array('database','ignite');

   // Helpers
   // if you want to autoload url helper, make sure to
   // autoload baka_common before it
   $autoload['helper'] = array('baka_common','url');

   // Configs
   $autoload['config'] = array('bakaigniter'); // Required!

   // Language
   $autoload['language'] = array('bakaigniter'); // Required!
   ```

6. **Done!**

## Credits

+ [Codeigniter](http://ellislab.com/codeigniter)
+ [CI Tank Auth Enchance (modified)](http://github.com/TankAuth/Tank-Auth/tree/enchance)
+ [Cool PHP Captcha](https://code.google.com/p/cool-php-captcha/)
+ [Google ReCaptcha (optional)](http://recaptcha.net/plugins/php/)

## Copyright and license

**Various trademarks and licenses held by their respective owners.**