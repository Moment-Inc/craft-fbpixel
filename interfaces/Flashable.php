<?php

namespace Craft;

interface Flashable {
    public function setFlash($data);
    public function checkFlash();
}