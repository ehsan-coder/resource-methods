

![Logo](https://s8.uupload.ir/files/eh_h1z0.jpg)

# Eloquent API Resource Methods

API Resources in laravel is very common,  If you are here, you most likely know about and use them.
API Resources is very useful, but it lacks a bit of the "Laravel way" when you want use methods such as except or only, because you may want to modified output
of the Resource. by this package you can do this!


## Installation

You can install the package via composer:
```javascript
 composer require ehsan-coder/resource-methods
```





## Usage/Examples

On any API Resource you want to be able to use the methods described below, you should use the following trait:

```javascript
use EhsanCoder\ResourceMethods;

class UserResource extends JsonResource
{
    use ResourceMethodsTrait;
}
```

This package provides a few features.

#### Only method
if your resource have a toArrray method like this, you can use only method such as below:

```javascript
    public function toArray($request)
    {
        $response = [
            'id'              => $this->id,
            'username'        => $this->username,
            'status'          => $this->status,
            'name'            => $this->name,
        ];
        return $response;
    }
```

```javascript
    $user                 = \App\Models\User::query()->first();
    $userThatHaveOnlyName = \App\Http\Resources\UserResource::make($user)->only('name');
```
in this method, if you want use multi property for apply only method you can use such as below:
```javascript
    $user                      = \App\Models\User::query()->first();
    $userThatHaveOnlyNameAndId = \App\Http\Resources\UserResource::make($user)->only(['id','name']);
```

#### Except method
if your resource have a toArrray method like this, you can use except method such as below:

```javascript
    public function toArray($request)
    {
        $response = [
            'id'              => $this->id,
            'username'        => $this->username,
            'status'          => $this->status,
            'name'            => $this->name,
        ];
        return $response;
    }
```

```javascript
    $user                 = \App\Models\User::query()->first();
    $userThatHaveAllPropertiesExceptName = \App\Http\Resources\UserResource::make($user)->except('name');
```
in this method, if you want use multi property for apply except method you can use such as below:
```javascript
    $user                      = \App\Models\User::query()->first();
    $userThatHaveAllPropertiesExceptNameAndId = \App\Http\Resources\UserResource::make($user)->except(['id','name']);
```

in except method, you can do a magical work! if you have a  nested json, In other words you have a property with value json you can except any key-value into this json value, for examaple:

```javascript
    $device                      = \App\Models\Devices::query()->first();
    $deviceThatExceptSomeKeyValuesInModelJsonProperty = \App\Http\Resources\DeviceResource::make($device)->except(['model->name', 'model->brand->country'])
```

#### overwrite method
in this method you can modified any value of any output resource propery.for example:
```javascript
    $user                          = \App\Models\User::query()->first();
    $camelCaseNameValueForThisUser = \App\Http\Resources\UserResource::make($user)->overwrite('name', fn(string $name) => camel_case($name));
```

## Feedback

If you have any feedback, please reach out to us at msc.shafiei@gmail.com

