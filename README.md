# Export Active Products as XML module
## Description
a simple prestashop module that when installed adds a link on the shop parameter tab of the admin side menu that leads to the download of an xml file containing all active shop products and their basic properties.

## Installation
You will need docker-compose, as this testing-instance uses prestashop flashlight
1. run ```docker compose up```
2. after prestashop sets up correctly go to ```localhost:8000/admin-dev```
3. login with email:```admin@prestashop.com``` password ```prestashop```
4. navigate to Modules > Modules Manager and Install Export Products as XML module
5. Advanced Parameters > Performance > Clear Cache
6. on the side menu open Shop Parameters > Export Active Products as XML and a download will be prompted.

#### [Read more about the module](modules/activeproductexportxml/Readme.md)