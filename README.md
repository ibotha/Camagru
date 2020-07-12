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

## Structure

### Files
The files in this project are split into 4 main categories:
1. config: These are files used for the setup of the website. Not for users.
2. control: These are .js files that contain all the client-side functionality of the website.
3. modal: These are server-side .php files that handle modification of the database and retrieval of information
4. view: These are .php files that render out into webpages and are sent to the user. AKA the frontend.

### Flow
The flow of the webite is as follows:

1. The user navigates to the website and requests a view. (home, gallery, profile...)
2. The server checks privilages and either returns the view or the user is rerouted.
3. The returned html requests the required control files.
4. The user interacts with the website.
5. The control files send post requests with the relevant information to modal files.
6. The modal files update the database accordingly and return relevant information
7. The control files update the webpage with the new information
8. repeat steps 4 through 7 until the user navigates away or to a different view

[preview]: ./Preview/Preview.png
[lamp]: https://bitnami.com/stack/lamp
[wamp]: https://bitnami.com/stack/wamp
[mamp]: https://bitnami.com/stack/mamp
[Hmailserver]: https://www.hmailserver.com/