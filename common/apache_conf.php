<VirtualHost *:80>
    //虚拟主机web根目录
    DocumentRoot "G:/yii2_study/blog/frontend/web"
    //虚拟主机名
    ServerName blog.com
    <Directory "G:/yii2_study/blog/frontend/web">
        //开启重写机制
        RewriteEngine on
        //如果访问的test.php不存在，则默认，访问index.php
        RewriteCond %{REQUEST_FILENAME} ! -f
        RewriteCond %{REQUEST_FILENAME} ! -d
        //默认规则，index.php
        RewriteRule . index.php
        //默认索引文件index.php
        DirectoryIndex index.php
    </Directory>
    ErrorLog "logs/blog.com-error.log"
    CustomLog "logs/blog.com-access.log" common
</VirtualHost>

<VirtualHost *:80>
    DocumentRoot "G:/yii2_study/blog/backend/web"
    ServerName admin.blog.com
    <Directory "G:/yii2_study/blog/backend/web">
        RewriteEngine on
        RewriteCond %{REQUEST_FILENAME} ! -f
        RewriteCond %{REQUEST_FILENAME} ! -d
        RewriteRule . index.php
        DirectoryIndex index.php
    </Directory>
    ErrorLog "logs/admin.blog.com-error.log"
    CustomLog "logs/admin.blog.com-access.log" common
</VirtualHost>