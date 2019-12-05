import { Component } from '@angular/core';
import { WeatherService } from './services/weather-service.service';
import { FormBuilder, Validators, FormGroup, FormControl } from '@angular/forms';
@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent {
  title = 'Weather Widget';
  spinner: boolean;
  temperatures = [];
  message:string;
   auth : FormGroup;

  constructor(private temperatureService: WeatherService,private formBuilder: FormBuilder,) {
    this.spinner = true;
    this.getRecentTemperatures();
    this.auth= this.formBuilder.group({
      temp: ['',  Validators.compose([ Validators.pattern('[0-9 ]*'), Validators.required])],
      date: ['', Validators.compose([Validators.required])]
    });
  }
  getRecentTemperatures() {

    this.temperatureService.getRecentTemperatures()
      .subscribe((res: any) => {
        this.spinner = false;
        this.temperatures = res;
        console.log(res);
      }, error => {
        console.error(error);
      });
  }

  updateTemp(){
    this.spinner = true;
    let temp =this.auth.value['temp'];
    let recordedDate =this.auth.value['date'];

    this.temperatureService.updateTemperatures(temp,recordedDate)
      .subscribe((res: any) => {
        this.spinner = false;
        this.message = res["response"];
        this.getRecentTemperatures();
        console.log(res);
      }, error => {
        console.error(error);
      });
    
  }
}
