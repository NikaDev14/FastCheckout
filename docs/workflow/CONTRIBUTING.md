# Welcome to FastCheckout contributing Guide

Thank you for investing your time to our project!
In this guide you will get an overview of the contribution workflow from opening an issue, creating a PR, reviewing, and merging the PR.
Pleaase read it attentively before asking for any merge requests :) 

## Taking an issue

Firstable, you have to know that all our backlog is stored in [Trello](https://trello.com/b/IkvACPYm/plan-gpe-d%C3%A9veloppeur "Trello FastCheckout"), in Backlog column.
If you want to take an issue, you will **imperatively** have to pass the ticket from "Backlog" to "In Progress" one.
Once you did that, all the developers can know that someone is already on it.
You can now pass to the next step, the git branch managing.

## GitHub Flow

### Branching

Now you will have to create a new branch from **updated dev** (to avoid any conflict) and will have to name your branch.
It is quite simple :
Your first word will be **back** (if the ticket is concerning backend) or **front** (if frontend).
It can also be **docs** if the issue is a lack of documentation.
This keywork will preced a simple "/".

If your issue is a new feature for the application, you will start with **feat** keyword.
If your issue is a bug fixing, you will start with **fix** keyword.

After that, you will have to define the issue's id which is in Trello which will preced a "-".

Finally, finalize your branch naming with a **simple description of the task**, always in **Kebab Case**.

in this chapter, we will see 2examples : 

- The ticket is a feature in front office (Trello Ticket id : 50) and the developer has to implement a new button while an user is registering.

The branch name will be : **front/feat-50-update-register-form**

- The ticket is a fix in back office (Trello Ticket id : 48) and the developer has to fix the authentication flow.

The branch name will be : **back/fix-48-update-user-auth**

**Note** : Please always use lowercases. 

### Commit message

Before pushing your modifications, pls be explicit on commit message on what actions you made.

**Note** : You can use upper cases in your messages, but please do not exceed 70/80 characters. 

### Merge Requests

All your modifications will have to pass by **dev** and not main, which is our stable branch.
Pls never push directly on it.

Happy Hacking! :) 
