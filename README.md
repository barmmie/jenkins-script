# Jenkins api reader - Seedstars challenge 2

**console script**

Create a script, in PHP, that uses Jenkins' API to get a list of jobs and their status from a given jenkins instance. The status for each job should be stored in an sqlite database along with the time for when it was checked.

**Usage/Installation**

```
# clone repository
$ git clone https://github.com/barmmie/jenkins-script.git

# change directory
$ cd jenkins-script

# run script with default server "https://builds.apache.org"
$ php jenkins.php

# You can also specify a server or/and database in this format "php jenkins.php {server} {database} " E.g
$ php jenkins.php https://jenkins.qa.ubuntu.com ./ubuntu.db
```



