/**
 * @param {*} condition
 */
function assert(condition) {
    if (!condition) {
        throw new AssertError('An assertion has failed');
    }
}

class AssertError extends Error {}
