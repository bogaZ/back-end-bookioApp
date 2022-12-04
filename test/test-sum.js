var test = require('tape')
test('sum module', function (t) {
  var sum = require('../src/sum.js')
  t.ok(sum(1, 2), 3, "Sums appear correct")
  t.end()
})
