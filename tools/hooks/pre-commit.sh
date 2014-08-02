#!/bin/bash

# @TODO this should consider the --staged version of the files, can we make sure this happens?
vendor/bin/phpcs --standard=tools/phpcs src tests

# exits with the result of the previous command
exit $?