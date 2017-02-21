# Block Storage

## List all Volumes

List all the volumes associated with the account.

### Example Usage

```php
<?php

use wappr\digitalocean\BlockStorage;
use wappr\digitalocean\Requests\BlockStorage\ListAllBlockStorageRequest;

include '../vendor/autoload.php';

$blockStorage = new BlockStorage;
$result = $blockStorage->listAll(new ListAllBlockStorageRequest);
var_dump($result->getStatusCode()); // 200
```

## Create a new volume

Create a new Block Storage volume.

### Example Usage

```php
<?php

use wappr\digitalocean\BlockStorage;
use wappr\digitalocean\Requests\BlockStorage\CreateBlockStorageRequest;

include '../vendor/autoload.php';

$blockStorage = new BlockStorage;
$result = $blockStorage->create(new CreateBlockStorageRequest(100, 'test'));
var_dump($result->getStatusCode()); // 200
```

## Additional docs

[DigitalOcean's docs on BlockStorage](https://developers.digitalocean.com/documentation/v2/#block-storage)