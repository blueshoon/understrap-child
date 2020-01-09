# WP Engine + Codeship Continuous Deployment/Delivery
This deployment script and documentation are based on [this article](https://linchpin.agency/blog/continuous-deployment-wp-engine-codeship/?utm_source=github&utm_medium=deployments&utm_campaign=wpengine).

This script will assist you in automatically deploying WordPress plugins and themes to [WP Engine .git deployment](https://wpengine.com/git/) using [Codeship](https://codeship.com) or other deployment services.

### The instructions and the deployment script assumes the following

* You are using Codeship as your CI/CD solution.
* You understand how to setup [.git deployments on WP Engine](https://wpengine.com/git/) already.
* You are using the **master** branch of your repo for your **Production** instance
* You are using the **staging** branch of your repo for your **Staging** instance
* You are using the **develop** branch of your repo for your **Development** instance

### How do I get set up?

* [Configuration](#configuration)
* [Codeship Environment Variables](#codeship-environment-variables)
* [Deployment instructions](#deployment-instructions)
* [Useful notes](#useful-notes)

### Configuration

1. Log into **codeship.com**
1. Create a new project and connect the github repo to codeship
1. Add the SSH key from the previous step to the site in WP Engine
1. Setup [Environment Variables](#codeship-environment-variables)
    * Environment variables are a great way to add flexibility without having variables hard coded within the script
    * You should never have any credentials stored within this repo

### Codeship Environment Variables

The environment variables below are required

|Variable|Description|Required|
| ------------- | ------------- | ------------- |
|**REPO_NAME**|The repo name should match the git repository name|**YES**|
|**WPE_INSTALL_PROD**|The subdomain of your WP Engine install|**YES**|


The variables below are not required, but are utilized to work with WP Engine's current multi-environment setup. Moving away from legacy staging, WP Engine now utilizes 3 individual installs under one "site". The are all essentially part of your same hosting environment, but are treated as Production, Staging, and Development environments when it comes to your workflow.

|Variable|Description|Required|
| ------------- | ------------- | ------------- |
|**WPE_INSTALL_STAGE**|The subdomain from WP Engine install "Staging"||
|**WPE_INSTALL_DEV**|The subdomain from WP Engine install "Development"||

## Deployment Instructions

The below build script will run the shell script from the project which kicks off the build and deploy scripts accordingly based on the environment variables.

In order to deploy to your pipeline, add the following command to the **Custom Scripts** section of your Codeship Project.

```
# allow execution of our build/deploy script and load it from the repo
chmod 555 ./wpengine-codeship-ci/deploy.sh
./wpengine-codeship-ci/deploy.sh
```

The version of node-sass that gulp-sass references currently errors out during builds on versions of Node > 10.  To work around this for now, in Codeship Tests add the following to **Setup Commands**:

```
nvm install 10
npm rebuild node-sass
```

## Useful Notes

* WP Engine's .git push can almost be considered a "middle man" between your repo and what is actually displayed to your visitors within the root web directory of your website. After the files are .git pushed to your production, staging, or develop remote branches they are then synced to the appropriate environment's webroot.

* If an SFTP user in WP Engine has uploaded any files to staging or production those assets **WILL NOT** be added to the repo.
* Additionally there are times where files need to deleted that are not associated with the repo. In these scenarios we suggest deleting the files using SFTP.
