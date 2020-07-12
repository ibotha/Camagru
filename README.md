# CAMAGRU

Camagru is a simple image editing and posting web-app similar to instagram.

![preview]

## Installation
For installation on your local system follow these instructions.
### Requirements
#### Windows
* [Wamp]
* [hmailserver]
#### Linux
* [Lamp]
#### MacOS
* [Mamp]
  
### Instructions
1. Install requirements for your system.
2. Clone the repository into the htdocs folder of Wamp, Lamp or Mamp. From now on we will reffer to the cloned folder name as "Camagru"
3. Enter database credentials into config/database.php.
4. Navigate to [localhost/Camagru/config/setup.php](http://localhost/Camagru/config/setup.php) to create the database.
5. Navigate to [localhost/Camagru/modal/addSticker.php](http://localhost/Camagru/modal/addSticker.php). There will be a single text field.
6. Input an absolute path to a local image file that will be uploaded as a sticker and press enter.
7. Repeat step 6 for all stickers you wish to upload.

The server should now be up and running in full.

[preview]: ./Preview/Preview.png
[lamp]: https://bitnami.com/stack/lamp
[wamp]: https://bitnami.com/stack/wamp
[mamp]: https://bitnami.com/stack/mamp
[Hmailserver]: https://www.hmailserver.com/