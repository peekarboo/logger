# grad2021-sharon-logger
### Installation

_Below is an example of how you can  install this package
1. Run
   ```Composer Install
   ```
2. Include this in your class
   ```use Ampersandhq\ChallengeLogger;

   ```
4. Log  `config.js`
   ```private $logger;
    ```
    
 ```
 
    public function __construct(LoggerInterface $logger)
    {
        
        $this->logger = $logger;
    }
    

   ```
   
	```
    public function testLogger()
    {
        
        $this->logger->log(info, "We are testing the logger ")
    }
    

   ```