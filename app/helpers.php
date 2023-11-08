<?php

if (! function_exists('getTirePackages')) {
    function getTirePackages($profile, $width, $diameter, $is_commercial, $amount)
    {
        $packages = 0;

        switch ($diameter) {
            case 17:
                if ($width == 205 && $profile == 40 && ! $is_commercial) {
                    $packages = $amount / 4;
                } elseif ($width == 205 && $profile == 40 && ! $is_commercial) {
                    $packages = $amount / 4;
                } else {
                    $packages = $amount / 2;
                }
                break;
            case 16:
                switch ($profile) {
                    case 50:
                    case 55:
                        if ($width == 225) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 60:
                        if (in_array($width, [225, 255])) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 65:
                        if (in_array($width, [215, 255])) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 70:
                        if (in_array($width, [215, 225, 235, 245, 255, 265, 275])) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 75:
                        if (in_array($width, [215, 225, 235, 245, 265])) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 80:
                        if ($width == 205) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 85:
                        if (in_array($width, [215, 235])) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    default:
                        $packages = $amount / 4;
                        break;
                }
                break;
            case 15:
                switch ($profile) {
                    case 70:
                        if (in_array($width, [205, 225, 265])) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 75:
                        if ($width == 235) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    case 80:
                        if (in_array($width, [195, 215])) {
                            $packages = $amount / 2;
                        } else {
                            $packages = $amount / 4;
                        }
                        break;
                    default:
                        $packages = $amount / 4;
                        break;
                }

                break;
            case 14:
                if ($is_commercial) {
                    switch ($profile) {
                        case 75:
                            if (in_array($width, [195, 205])) {
                                $packages = $amount / 2;
                            } else {
                                $packages = $amount / 4;
                            }
                            break;
                        case 80:
                            if (in_array($width, [185, 195, 205, 215])) {
                                $packages = $amount / 2;
                            } else {
                                $packages = $amount / 4;
                            }
                            break;
                        default:
                            $packages = $amount / 2;
                            break;
                    }

                    if ($profile > 80) {
                        $packages = $amount / 2;
                    } elseif ($profile < 70) {
                        $packages = $amount / 4;
                    }
                } else {
                    $packages = $amount / 4;
                }
                break;
            case 13:
            case 12:
                $packages = $amount / 4;
                break;
            default:
                $packages = $amount / 2;
                break;
        }

        return $packages;
    }
}
