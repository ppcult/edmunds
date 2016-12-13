
from test.TestCase import TestCase
import Edmunds.Support.helpers as helpers
from edmunds.test.Edmunds.Foundation.SysLogServer import SysLogServer


class SysLogTest(TestCase):
	"""
	Test the SysLog
	"""

	def set_up(self):
		"""
		Set up the test case
		"""

		super(SysLogTest, self).set_up()

		self._server = SysLogServer()
		self._server.start()


	def tear_down(self):
		"""
		Tear down the test case
		"""

		super(SysLogTest, self).tear_down()

		self._server.stop()


	def test_sys_log(self):
		"""
		Test the sys log
		"""

		info_string = 'info_%s' % helpers.random_str(20)
		warning_string = 'warning_%s' % helpers.random_str(20)
		error_string = 'error_%s' % helpers.random_str(20)

		# Write config
		self.write_test_config([
			"from Edmunds.Log.Drivers.SysLog import SysLog \n",
			"from logging import WARNING \n",
			"APP = { \n",
			"	'debug': False, \n",
			"	'log': { \n",
			"		'enabled': True, \n",
			"		'instances': [ \n",
			"			{ \n",
			"				'name': 'syslog',\n",
			"				'driver': SysLog,\n",
			"				'level': WARNING,\n",
			"				'address': ('%s', %i),\n" % (self._server.host, self._server.port),
			"			}, \n",
			"		], \n",
			"	}, \n",
			"} \n",
		])

		# Create app
		app = self.create_application()

		# Add route
		rule = '/' + helpers.random_str(20)
		@app.route(rule)
		def handleRoute():
			app.logger.info(info_string)
			app.logger.warning(warning_string)
			app.logger.error(error_string)
			return ''

		with app.test_client() as c:

			# Check syslog
			self.assert_not_in(info_string, '\n'.join(self._server.get_data()))
			self.assert_not_in(warning_string, '\n'.join(self._server.get_data()))
			self.assert_not_in(error_string, '\n'.join(self._server.get_data()))

			# Call route
			c.get(rule)

			# Check syslog
			self.assert_not_in(info_string, '\n'.join(self._server.get_data()))
			self.assert_in(warning_string, '\n'.join(self._server.get_data()))
			self.assert_in(error_string, '\n'.join(self._server.get_data()))
