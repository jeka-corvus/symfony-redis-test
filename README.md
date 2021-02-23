### Installation

To start the project, you need to do the following steps:

1. Need to copy and rename the file .env.example to .env

1. Run docker containers using command: _docker-compose up --build_


### Available commands
1. #### _message:push_

 Commands for adding a message to the queue: _docker-compose exec app php bin/console message:push_. This command will ask you to enter any message

2. #### _message:receive_
To receive one unread message, use: _docker-compose exec app php bin/console message:receive_
