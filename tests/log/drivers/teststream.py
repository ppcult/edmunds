
from tests.testcase import TestCase


class TestStream(TestCase):
    """
    Test the Stream
    """

    def test_stream(self):
        """
        Test the stream
        """

        info_string = 'info_%s' % self.rand_str(20)
        warning_string = 'warning_%s' % self.rand_str(20)
        error_string = 'error_%s' % self.rand_str(20)

        # Write config
        self.write_config([
            "from edmunds.log.drivers.stream import Stream \n",
            "from logging import WARNING \n",
            "try: \n",
            "   from cStringIO import StringIO \n",
            "except ImportError: \n",
            "   from io import StringIO \n",
            "APP = { \n",
            "   'debug': False, \n",
            "   'log': { \n",
            "       'enabled': True, \n",
            "       'instances': [ \n",
            "           { \n",
            "               'name': 'stream',\n",
            "               'driver': Stream,\n",
            "               'stream': StringIO(),\n",
            "               'level': WARNING,\n"
            "               'format': '%(message)s',\n",
            "           }, \n",
            "       ], \n",
            "   }, \n",
            "} \n",
        ])

        # Create app and fetch stream
        app = self.create_application()
        stream = app.config('app.log.instances')[0]['stream']

        # Add route
        rule = '/' + self.rand_str(20)
        @app.route(rule)
        def handle_route():
            app.logger.info(info_string)
            app.logger.warning(warning_string)
            app.logger.error(error_string)
            return ''

        with app.test_client() as c:

            # Check stream
            self.assert_not_in(info_string, stream.getvalue())
            self.assert_not_in(warning_string, stream.getvalue())
            self.assert_not_in(error_string, stream.getvalue())

            # Call route
            c.get(rule)

            # Check stream
            self.assert_not_in(info_string, stream.getvalue())
            self.assert_in(warning_string, stream.getvalue())
            self.assert_in(error_string, stream.getvalue())
