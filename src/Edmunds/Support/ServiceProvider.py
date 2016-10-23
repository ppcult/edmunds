
import abc


class ServiceProvider(object):
	"""
	The Service Provider
	"""

	__metaclass__ = abc.ABCMeta


	def __init__(self, app):
		"""
		Initialize the application
		:param app: 	The application
		:type  app: 	Application
		"""

		self.app = app


	@abc.abstractmethod
	def register(self):
		"""
		Register the service provider
		"""
		pass