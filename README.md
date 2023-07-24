# minimal-web-notepad

这是一个在 [pereorga/minimalist-web-notepad](https://github.com/pereorga/minimalist-web-notepad) 上添加了额外功能的分支。附加的代码使得体积增加了，所以不再是极简，但是在经过压缩和gzip后仅有10KB。如果你想要真正极简的版本，pereorga 的实现小于 3KB，而且还没有经过压缩！

密码功能是通过在文本文件中添加一个头部行来实现的，该行在便签中不显示。请注意，这并不会加密内容，只是限制访问权限。服务器的唯一要求是启用了 mod_rewrite 的 Apache Web 服务器或启用了 ngx_http_rewrite_module 和 PHP 的 nginx Web 服务器。

![编辑界面截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_001749.png)

对 pereorga 的原始版本添加了以下功能：
- 可以在便签中显示超链接的查看选项（在移动设备上非常有用）
- 支持密码保护，并提供只读访问选项
- 仅查看链接
- 显示便签的上次保存时间
- 将便签的URL、只读URL和便签文本复制到剪贴板
- 以无衬线字体或等宽字体查看便签
- 可以下载便签
- 显示可用的便签列表
- 可以根据需要打开或关闭功能以减小页面大小

可以在 汉化版：https://7t.vc 或原版 http://note.rf.gd/ 或 http://note.rf.gd/some-note-name-here 上查看演示。由于演示没有启用 HTTPS，所以浏览器中会显示密码警告，请仅用于测试，不要用于其他用途。

截图：
**便签查看模式**
![查看界面截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_001758.png)

**适配移动设备的响应式菜单**
![移动菜单截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_003719.png)
![移动菜单截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_003659.png)

**等宽字体**
![等宽字体截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_001901.png)

**密码保护**
![密码保护截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_001922.png)

**受保护便签的密码提示**
![密码提示截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_002013.png)

“以只读模式查看”链接仅显示便签文本，不显示其他内容

**复制到剪贴板的链接**
![复制截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_002105.png)

**便签列表**
- 通常仅用于非公开的 URL，尽管页面是受密码保护的
![便签列表截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_002159.png)

如果不想显示便签列表，可以在 index.php 文件顶部将 $allow_noteslist 参数设置为 false，或者将 `notelist.php` 重命名为其他名称。便签列表页面的密码位于 `notelist.php` 文件的顶部，可以使用 `Protect\with('modules/protect_form.php','在这里更改密码')` 进行修改。

**备选编辑视图**
还有一种备选的编辑视图，可以在便签后添加 `?simple` 来访问，例如 /quick?simple。我个人觉得这个视图非常适合在手机上快速添加便签，它在页面顶部有一个较小的编辑区域，当你输入文本并按下回车键时，它会将文本添加到便签中，并将其移动到占据页面剩余部分的视图中。此视图部分将 URL 显示为可点击的链接。您不能在此视图上设置密码，但它会遵循已有的密码。

![复制截图](https://raw.githubusercontent.com/VMCoud/minimal-web-notepad/master/image/Screenshot_20230725_002735.png)

安装：
只要启用了 mod_rewrite 并且 Web 服务器被允许写入 `_notes` 数据目录，就不需要进行任何配置。这个数据目录在 `config.php` 文件中设置，所以如果你想要将其更改为原始 pereorga/minimalist-web-notepad 版本使用的文件夹，请在那里进行修改。所有的便签都以文本文件的形式存储，所以运行 Apache（或 Nginx）的服务器应该就足够了，不需要使用数据库。如果便签无法保存，请检查 `_notes` 目录的权限，通常 0755 或 744 就足够了。

![权限截图](https://raw.github.com/domOrielton/minimal-web-notepad/screenshots/mn_permissions.png)

还有一个 `setup.php` 页面，可以用来检查 `_notes` 目录是否存在并且可以写入。如果无法保存便签，可以尝试删除 `_notes` 目录，然后访问 `setup.php` 页面以创建该文件夹。如果一切正常，可以选择删除 `setup.php` 文件。

可能有些情况下需要将 `config.php` 文件中的 $base_url 变量替换为您安装的硬编码 URL 路径。如果是这种情况，请将以 `$base_url=dirname('//')` 开头的行替换为 `$base_url='http://actualURL.com/notes'`，将 actualURL.com/notes 替换为与您的安装相关的内容。

### 在 Apache 上
可能需要启用 mod_rewrite 并在站点配置中设置 `.htaccess` 文件。请参阅 [在 Ubuntu 14.04 上设置 Apache 的 mod_rewrite](https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite-for-apache-on-ubuntu-14-04)。

## 在 Nginx 上
在 Nginx 上，需要确保 nginx.conf 文件正确配置以确保应用程序按预期工作。请检查 nginx.conf.example 文件或查看[没有密码问题的讨论](https://github.com/domOrielton/minimal-web-notepad/issues/4)。感谢 [eonegh](https://github.com/eonegh) 提供示例文件。
