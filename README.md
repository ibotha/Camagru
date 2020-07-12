# CAMAGRU

Camagru is a simple image editing and posting web-app similar to instagram. I created this in order to learn how to build a website.

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
3. configure the php.ini file to send emails
4. Enter database credentials into config/database.php.
5. Navigate to [localhost/Camagru/config/setup.php](http://localhost/Camagru/config/setup.php) to create the database.
6. Navigate to [localhost/Camagru/modal/addSticker.php](http://localhost/Camagru/modal/addSticker.php). There will be a single text field.
7. Input an absolute path to a local image file that will be uploaded as a sticker and press enter.
8. Repeat step 7 for all stickers you wish to upload.

The server should now be up and running in full.

## Tests
It is recommended to run these tests once the server is set up in order to ensure that everything is working properly

1. Navigate to [localhost/Camagru/](http://localhost/Camagru/)
2. Click signup and create an account. make sure to use a valid email address
3. Check your inbox for a verification email and verify your account. If you do not recieve one check that you have configured your php.ini and hmail server correctly
4. Log in to your account.
5. click on *Camagru* in the top left corner and attempt to take a photo.
6. Select a sticker and enter a title.
7. click *post*
8. Your post should appear in the feed now.
9. Comment on, and like your post, then refresh. If the comment and like are still present all is well.
10. Lastly attempt to delete the post.

If all these steps passed then the website is fully functional

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

### Database
The database is structured as follows:

#### users
* `int` *id* (primary key)
* `varchar(255)` *email* (unique)
* `varchar(40)` *username* (unique)
* `tinyint(1)` *active* (has the user confirmed their email?)
* `varchar(1000)` *password* (the user's hashed password)
* `timestamp` *creationDate*
* `varchar(1000)` *verif* (a token to validate the user's email with)
* `tinyint(1)` *notify* (does the user want notifications?)

#### stickers
* `int` *id* (primary key)
* `varchar(255)` *path*

#### posts
* `int` *id* (primary key)
* `varchar(255)` *path*
* `int` *uploaderID* (foreign key to `users`.`id`)
* `timestamp` *creationDate*
* `varchar(255)` *description*

#### likes
* `int` *uploaderID* (foreign key to `users`.`id`)
* `int` *postID* (foreign key to `posts`.`id`)

#### comments
* `int` *id* (primary key)
* `int` *uploaderID* (foreign key to `users`.`id`)
* `int` *postID* (foreign key to `posts`.`id`)
* `timestamp` *creationDate*
* `varchar(1000)` *content*


[preview]: ./Preview/Preview.png
[lamp]: https://bitnami.com/stack/lamp
[wamp]: https://bitnami.com/stack/wamp
[mamp]: https://bitnami.com/stack/mamp
[Hmailserver]: https://www.hmailserver.com/