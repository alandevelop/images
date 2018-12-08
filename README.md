 <h3>О проекте:</h3>
                
<b>Пользователи для тестирования:</b>
<ul>
    <li>email: test@test.com, pswd: test</li>
    <li>email: admin@admin.com, pswd: admin</li>
</ul>

<b>Некоторые возможности реализованного функционала в проекте:</b>
<ul>
    <li>Авторизация с помощью Вконтакте по протоколу OAuth2</li>
    <li>Механизм подписок с использованием Redis</li>
    <li>Изменение размера изображения поста сразу после загрузки с сохранением пропорций</li>
    <li>Контроль доступа в админ панель на основе ролей (RBAC)</li>
    <li>Возможность назначать админом дополнительных пользователей</li>
    <li>
        С помощью AJAX реализовано:
        <ul>
            <li>Лайки к постам с подсчетом их количества</li>
            <li>Возможность подать жалобу на пост + одобрение/удаление поста в админ панели</li>
            <li>Изменение описание своего профиля</li>
            <li>Загрузка аватара</li>
            <li>Удаление своих постов</li>
        </ul>
    </li>
</ul>
                

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
