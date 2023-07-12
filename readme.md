# This is a module for sending push notification from Laravel
## This module aims to send push notifications via __Topic__

** You need to subscribe each user to 2 firebase topics on android
** 1. 'role'.'_'.$user->role_id
** 2. 'user'.'_'.$user_id


