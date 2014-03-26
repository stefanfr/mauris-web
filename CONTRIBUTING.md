Mauris
======

# How to contribute

We welcome your contributions. There are several ways to help out:
* Create an [issue](http://redmine.cvo-technologies.com/projects/schedule-system) on our Redmine server, if you have found a bug
* Write testcases for open bug issues
* Write patches for open bug/feature issues, preferably with testcases included

There are a few guidelines that we need contributors to follow so that we have a
chance of keeping on top of things.

## Getting Started

* Make sure you have a [GitHub account](https://github.com/signup/free).
* Submit an [issue](http://redmine.cvo-technologies.com/projects/schedule-system), assuming one does not already exist.
  * Clearly describe the issue including steps to reproduce when it is a bug.
  * Make sure you fill in the earliest version that you know has the issue.
* Fork the repository on GitHub.

## Making Changes

* Create a topic branch from where you want to base your work.
  * This is usually the master branch.
  * Only target release branches if you are certain your fix must be on that
    branch.
  * To quickly create a topic branch based on master; `git branch
    master/my_contribution master` then checkout the new branch with `git
    checkout master/my_contribution`. Better avoid working directly on the
    `master` branch, to avoid conflicts if you pull in updates from origin.
* Make commits of logical units.
* Check for unnecessary whitespace with `git diff --check` before committing.
* Use descriptive commit messages and reference the #issue number.
* Your work should apply the CakePHP coding standards.

## Which branch to base the work

* Bugfix branches will be based on master.
* New features that are backwards compatible will be based on next minor release
  branch.
* New features or other non-BC changes will go in the next major release branch.

## Submitting Changes

* Push your changes to a topic branch in your fork of the repository.
* Submit a pull request to the repository in the CVO-Technologies GitHub organization, with the
  correct target branch.

## Translating

Helping with translations is possible on the CVO-Technologies Weblate server

[![Translation status](http://weblate.mms-projects.net/widgets/mauris-287x66-grey.png)](http://weblate.mms-projects.net/engage/mauris/?utm_source=git-repository)

# Additional Resources

* [CakePHP coding standards](http://book.cakephp.org/2.0/en/contributing/cakephp-coding-conventions.html)
* [Existing issues](http://redmine.cvo-technologies.com/projects/schedule-system/issues)
* [Development Roadmaps](http://redmine.cvo-technologies.com/projects/schedule-system/roadmap)
* [General GitHub documentation](https://help.github.com/)
* [GitHub pull request documentation](https://help.github.com/send-pull-requests/)
