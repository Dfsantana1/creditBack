### Laravel Sail with WSL2/Docker/Ubuntu installation steps

1. Get WSL (Window subsystem layer/ library) & follow the instructions.

   [WSL installation guide](https://learn.microsoft.com/en-us/windows/wsl/install)


2. Now, let's download ubuntu 20.04 LTS or latest version from microsoft store.

   [Ubuntu installation guide](https://pureinfotech.com/install-windows-subsystem-linux-2-windows-10)

3. Open windows default command prompt in administrator mode.
   Note: follow the steps mentioned in documents.


4. Install ubuntu on Windows and ask for mount directory while installation

5. After installing ubuntu you can go to application search for ubuntu that will open ubuntu terminal

6. Now you will have ubuntu system inside windows and you install required software
   PHP and its required extension
   mysql 8.0

7. You can go to your mount directory or codebase directory and run following command, this will install all dependency for your project.
    ```
    docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html     -w /var/www/html     laravelsail/php81-composer:latest     composer install --ignore-platform-reqs
    ```

8. you can also make virtual host to access in browser with nginx or you can visit  http://localhost

9. Connect database UI: Either you can connect via https://www.adminer.org/ by adding this file locally and access it, and you can use other tools as well. like Mysql Work bench,in php storm as well.