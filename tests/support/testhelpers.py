
from tests.testcase import TestCase
import edmunds.support.helpers as helpers


class TestHelpers(TestCase):
    """
    Test the helpers
    """

    def test_random_str(self):
        """
        Test random_str
        """

        # Test length
        self.assert_equal(0, len(helpers.random_str(0)))
        self.assert_equal(7, len(helpers.random_str(7)))
        self.assert_equal(23, len(helpers.random_str(23)))
        self.assert_not_equal(23, len(helpers.random_str(32)))

        # Test uniqueness
        self.assert_equal(helpers.random_str(0), helpers.random_str(0))
        self.assert_not_equal(helpers.random_str(7), helpers.random_str(7))
        self.assert_not_equal(helpers.random_str(23), helpers.random_str(23))
        self.assert_not_equal(helpers.random_str(32), helpers.random_str(32))

    def test_random_int(self):
        """
        Test random_int
        """

        self.assert_less_equal(1, helpers.random_int(1, 10))
        self.assert_greater_equal(10, helpers.random_int(0, 10))
        self.assert_less_equal(1, helpers.random_int(1, 100))
        self.assert_greater_equal(100, helpers.random_int(0, 100))
        self.assert_less_equal(1, helpers.random_int(1, 1000))
        self.assert_greater_equal(1000, helpers.random_int(0, 1000))

    def test_snake_case(self):
        """
        Test snake case
        """

        data = (
            ('CamelCase',               'camel_case'),
            ('CamelCamelCase',          'camel_camel_case'),
            ('Camel2Camel2Case',        'camel2_camel2_case'),
            ('getHTTPResponseCode',     'get_http_response_code'),
            ('get2HTTPResponseCode',    'get2_http_response_code'),
            ('HTTPResponseCode',        'http_response_code'),
            ('HTTPResponseCodeXYZ',     'http_response_code_xyz'),
        )

        for test in data:
            self.assert_equal(test[1], helpers.snake_case(test[0]))
