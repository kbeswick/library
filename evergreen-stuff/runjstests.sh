#!/bin/bash
#
# Author: Kevin Beswick <kevinbeswick00@gmail.com>
#
# A script that sets up the DOH test environment if necessary, and runs the tests
# for either OpenSRF or Evergreen, depending on the location it detects
#
# USAGE:
# Just drop this into the root folder of the OpenSRF or Open-ILS source code and
# run. Run with '--cleanup' to delete the files it downloads.
#
# This script is only meant as an aid to make it easier to run the Javascript
# unit tests and is not guaranteed to work correctly on your system configuration

DOJO_VERSION="1.6.0"
SINON_VERSION="1.0.0"

runTests() {
    if [ -d "Open-ILS" ]; then
        opensrfils="openils"
    else
        opensrfils="opensrf"
    fi

    if [ ! -d "dojo-release-${DOJO_VERSION}-src" ]; then
        downloadFiles
    fi

    cd dojo-release-${DOJO_VERSION}-src/util/doh
    sh runner.sh testModule=${opensrfils}.tests.module
}

downloadFiles() {
    echo
    echo "Can't detect dojo directory, installing..."
    echo
    wget http://download.dojotoolkit.org/release-${DOJO_VERSION}/dojo-release-${DOJO_VERSION}-src.tar.gz
    tar xzf dojo-release-${DOJO_VERSION}-src.tar.gz
    rm dojo-release-${DOJO_VERSION}-src.tar.gz
    cd dojo-release-${DOJO_VERSION}-src
    wget http://sinonjs.org/releases/sinon-${SINON_VERSION}.js
    ln -s ../src/javascript/ opensrf
    ln -s ../src/javascript/DojoSRF.js DojoSRF.js
    cd ..
}

cleanupFiles() {
    rm -R dojo-release-1.6.0-src
    echo
    echo "The files installed by runjstests.sh have been deleted..."
    echo
}

showHelp() {
    echo
    echo "---------------------------------------------------"
    echo " runjstests.sh"
    echo "---------------------------------------------------"
    echo
    echo "Usage: runjstests.sh [--cleanup]"
    echo
    echo "Run this script in the root directory of the opensrf/open-ils codebase"
    echo
    echo "This script downloads files needed to run the tests, and executes them."
    echo "If you would like it to delete the files it downloaded, run with --cleanup option"
    echo
}

case "$1" in
    --cleanup)
        cleanupFiles
        ;;
    --help)
        showHelp
        ;;
    -h)
        showHelp
        ;;
    *)
        runTests
        ;;
esac
