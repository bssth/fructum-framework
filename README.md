<h2> Архитектура фреймворка </h2>

Структура Fructum Framework довольно проста.

Фреймворк использует шаблон проектирования HMVC (Иерархические Модель-Вид-Контроллер).

Самой высокоуровневой частью фреймворка является входная точка - файл, который провоцирует запуск приложения. На практике это может быть index.php скрипт для веб-сервера, или исполняемый файл операционной системы. Во входной точке всегда производится запуск приложения.

Приложения - условные понятия. Это классы, которые управляют вводом и выводом данных. Разделение на приложения позволяет сделать ваш проект универсальным - он сможет запускаться как из-под консоли, так и через браузер, при этом на каждый случай вы можете написать отдельные обработчики, но при всём этом использовать одни и те же библиотеки.

Примеры приложений:

    Веб-приложения (самые популярные; веб-сайты)
    Консольные приложения (те, которые запускаются через консоль ОС)

Когда входная точка включает (include\require) автозагрузчик, появляется возможность запустить приложение.

Автозагрузчик ищет нужное приложение, дальше выполняются соответствующие инструкции. В случае с веб-приложением запускается роутер, который определяет нужный путь, если же приложение консольное, запускается единый обработчик консольных приложений.

Все классы проекта (за исключением самого низкоуровневого ядра Fructum) содержатся в расширениях, модулях, хуках и самих скриптах фреймворка (далее системные классы).

Когда нужно загрузить какой-либо класс, в первую очередь автозагрузчик проверяет директорию с хуками. Хуки созданы для того, чтобы перезаписывать скрипты ядра и расширений. Также хуки можно использовать собственно для написания самого приложения.

Во вторую очередь проверяется каталог system с системными классами. Эти классы являются родными для Fructum и их директорию трогать крайне не рекомендуется во избежании проблем с совместимостью и обновлением фреймворка. Если вы хотите изменить системные классы, используйте хуки - создайте класс-хук с таким же названием, и до системных скриптов дело не дойдет.

В последнюю очередь проверяются расширения. Это - дополнения фреймворка, которые может написать и опубликовать каждый. Также их можно использовать для написания собственно приложения.

Расширение может иметь свои модули ("расширения расширений"). Модули созданы на случай, если расширение является крупным (например, CMS) и предусматривает модификацию. Чтобы определить принадлежность модуля к расширению, достаточно просто добавить префикс с именем расширения к названию модуля (например, test_module будет модулем для расширения test). Если добавить модуль к несуществующему расширению, он подгружаться не будет. 
<h2> Приложения в фреймворке </h2>

Приложение в Fructum Framework является низкоуровневой системой, которая определяет обработчики данных и управляет выводом ответа. Другими словами, это система, которая принимает данные, передает их обработчику и потом выводит.


Разделение на приложения требуется в тех случаях, когда отдаваемые и принимаемые данные могут быть разными. Если вы пишите консольное приложение, оно будет простым - просто принимающим и отдающим данные. Однако веб-приложения, кроме обычных данных, передают cookie и заголовки.

В стандартной сборке Fructum содержатся два вида приложений - консольные и веб-приложения.


Консольные приложения - это те приложения, которые запускаются через командную строку или SSH и единственными входными данными КП являются аргументы. Веб-приложения - это те приложения, которые запускаются через браузер и принимают GET\POST данные, cookie, заголовки и т.д. Отдаваемые данные также являются разновидными.


Для запуска вашего проекта требуется выполнить два шага: 1. Подключить фреймворк 2. Запустить приложение


Стандартная сборка настроена так, чтобы быть удобной при создании веб-приложений. Вышеупомянутые два шага запуска выполняются в так называемых входных точках. В случае с веб-приложением входной точкой является index.php. Этот скрипт принимает на себя все запросы HTTP, подключает фреймворк и запускает веб-приложения.


Если вы хотите написать свой вид приложений, рекомендуем взять за основу скрипт консольного приложения. Также при желании вы можете переделать стандартные приложения - переписать роутер веб-приложения или написать его для консольного. Для этого не потребуются дополнительные знания, просто изучите, как работают стандартные приложения и напишите расширение или хук. 
<h2> Консольные приложения </h2>

Консольные приложения являются самыми простыми - здесь не используется роутер и контроллеры, как в веб-приложениях. Стандартное приложение ConsoleApp после запуска ищет класс \Handler\Console и вызывает в нем метод run(). Если такого класса нет, возникнет критическая ошибка 
<h2> Конфигурация в фреймворке </h2>

Класс \Fructum\Config содержит необходимую конфигурацию фреймворка. Для её изменения следует создать свой хук, скопировав /system/Fructum/Config.php в /hooks/Fructum/Config.php и изменить содержимое на нужное вам. Каждый параметр задокументирован

Если ваше расширение требует настройки, не создавайте свой класс - просто обращайтесь к константам класса \Fructum\Config. Добавьте в инструкцию по установке расширения информацию о том, какие данные следует добавить в конфигурацию.

Обратите внимание! Данные в конфигурации - это константы, а не переменные. Используйте кострукцию const. 
<h2> Подробная информация </h2>

Вся подробная информация доступна на вики: http://wiki.blockstudio.net/wiki/Fructum