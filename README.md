# Here API Monitoring

# Prerequisites
Please make sure to adjust the values in the specific helm deployment value files. 
For more endpoints, adjust the index.php file inside the src folder.

## Deployment
```
helm --kube-context dev --namespace 'namespacename' upgrade 'helminstallname' ./deployment/ --install --recreate-pods
```

## Notes
Dockerfile is based on <https://github.com/TrafeX/docker-php-nginx/>
