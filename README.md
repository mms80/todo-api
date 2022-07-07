# todo-api

This project is defined for Laravel to design a project-independent package that adds the Todo ability to the main project. At the end, after copying your package files to the main project and adding it to composer , your package is expected to connect to the main project and enable the Todo feature for that project.


# Installation

`compser require mms80/todo-api`

## requires

- PHP ^7.4
- Laravel ^7.x

## environments

- [mailtrap](https://mailtrap.io/)

# Documentation

- All requests must include the "Authorization" parameter in the header (Authorization value is an Bearer TOKEN) .
### task api :
- To show all tasks of the logged in user :

	`GET "/tasks"`

- To create a task :

	`POST "/tasks" -d {"title":"foo","description":"bar","labels --optional":["label1","label2"]}`

- To show a task :

	`GET "/tasks/{id}"`

- To edit a task :

	`PUT "/tasks/{id}" -d {"title --optional":"foo","description --optional":"bar","labels --optional":["label1","label2"],"detaching --optional":"true"}`
	
	***"detaching" is an optional parameter . When it is true , new labels are added to the task and old labels are removed, and when it is false , new labels are added to old task labels (It is false by default).***

### label api :
- To Show all labels :

	`GET "/labels"`

- To create a label : 

	`POST "/labels" -d {"title --unique":"foo"}`

# Test
in the package folder path :

	`composer update`
	`composer run test`
