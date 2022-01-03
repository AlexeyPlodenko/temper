<?php

const BASEDIR = __DIR__ .'/../../';

require BASEDIR .'/vendor/autoload.php';
require BASEDIR .'/vendor/larapack/dd/src/helper.php';

// @TODO make configurable per env.
assert_options(ASSERT_ACTIVE, 1);
assert_options(ASSERT_WARNING, 1);
assert_options(ASSERT_BAIL, 1);
