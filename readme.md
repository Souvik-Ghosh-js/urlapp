# Deploying an App on Railway for Free - Step-by-Step Guide

## Introduction

This guide outlines the step-by-step process of deploying your application on Railway, a platform-as-a-service (PaaS) provider, for free. Railway simplifies the deployment process and offers features like managed databases, automatic scaling, and more.

### Prerequisites

1. **GitHub Account**: Create a GitHub repository to host your application code.
2. **Railway Account**: Sign up for a Railway account at [https://railway.app/](https://railway.app/).
3. **SQL Database (Optional)**: Decide whether you want to use an external SQL database or Railway's managed database.

## Step 1: Create GitHub Repository

1. Go to [https://github.com/](https://github.com/) and log in or sign up.
2. Create a new repository for your project.
3. Upload your application code to the repository.

## Step 2: Set Up Railway Project

1. Log in to your Railway account.

2. Create a new project by clicking on the "New Project" button.

3. Choose a name for your project and click "Create Project."

## Step 3: Configure SQL Server (Optional)

1. In your Railway project, navigate to the **Databases** tab.

2. Create a new SQL Server instance or choose an existing one.

## Step 4: Deploy Project from GitHub

1. In your Railway project, go to the **Deployments** tab.

2. Click on "Connect a Git Repository."

3. Connect your GitHub repository to your Railway project.

4. Select the branch you want to deploy and click "Deploy."

## Step 5: Configure Environment Variables

1. After deployment, go to the **Variables** tab in the Railway production environment.

2. If you are using an external SQL database, add the necessary environment variables with the database connection details.

3. Add the following lines to the environment variables:

    ```plaintext
    NIXPACKS_BUILD_CMD=composer update && composer install && php artisan optimize:clear && php artisan storage:link && php artisan migrate --force
    COMPOSER_ALLOW_SUPERUSER=1
    ```

## Step 6: Update Variables and Start Deployment

1. Update any other necessary environment variables based on your application requirements.

2. Save the changes.

3. Railway will automatically start the deployment process.

## Step 7: Access Your App

1. Once the deployment process is complete, you can access your application.

2. Railway provides a temporary domain for your app. Alternatively, you can add your custom domain through the Railway dashboard.

3. Your app is now successfully deployed on Railway!

## Conclusion

Congratulations! You have successfully deployed your application on Railway for free. Railway's user-friendly interface and seamless integration with GitHub make the deployment process straightforward. Explore additional features on the Railway platform to enhance your application deployment experience.
