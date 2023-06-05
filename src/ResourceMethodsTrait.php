<?php

namespace EhsanCoder\ResourceMethods;

use Illuminate\Http\Resources\MissingValue;

trait ResourceMethodsTrait
{
    public static $sampleObject = null;
    /**
     * @param  array|string  $attributes
     *
     * @return $this
     */
    public function except($attributes)
    {
        if (is_array($attributes)) {
            collect($attributes)->each(function ($attribute) {
                $parts = explode("->", $attribute);
                if (count($parts) > 1) {
                    $attribute    = $parts[0];
                    $temp         = $this->$attribute;
                    $accessString = '$temp';
                    for ($i = 1; $i < count($parts); $i++) {
                        $accessString .= '[$parts[' . $i . ']]';
                        if (!isset($temp[$parts[$i]])) {
                            break;
                        }
                    }
                    eval('unset( ' . $accessString . ');');
                    $this->$attribute = $temp;
                } else {
                    $this->$attribute = new MissingValue();
                }
            });
        } else {
            $parts = explode("->", $attributes);
            if (count($parts) > 1) {
                $attribute    = $parts[0];
                $temp         = $this->$attribute;
                $accessString = '$temp';
                for ($i = 1; $i < count($parts); $i++) {
                    $accessString .= '[$parts[' . $i . ']]';
                    if (!isset($temp[$parts[$i]])) {
                        break;
                    }
                }
                eval('unset( ' . $accessString . ');');
                $this->$attribute = $temp;
            } else {
                $this->$attributes = new MissingValue();
            }
        }

        return $this;
    }

    /**
     * @param  array|string  $attributes
     *
     * @return $this
     */
    public function only($attributes)
    {
        if (self::$sampleObject == null && $this->resource != null) {
            self::$sampleObject = $this->toArray(request());
        }
        if (is_array($attributes)) {
            collect(self::$sampleObject)->each(function ($value, $key) use ($attributes) {
                if (!in_array($key, $attributes)) {
                    $this->$key = new MissingValue();
                }
            });
        } else {
            collect(self::$sampleObject)->each(function ($value, $key) use ($attributes) {
                if ($key != $attributes) {
                    $this->$key = new MissingValue();
                }
            });
        }

        return $this;
    }

    /**
     * @param            $attribute
     * @param  callable  $callback
     *
     * @return $this
     */
    public function overwrite($attribute, callable $callback)
    {
        $this->$attribute = call_user_func($callback, $this->$attribute);

        return $this;
    }
}
