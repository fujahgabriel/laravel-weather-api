import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class WeatherService {
  private baseUrl = 'http://127.0.0.1:8000/api/';
  constructor(private http: HttpClient) { }
  getRecentTemperatures() {
    return this.http.get(this.baseUrl+'recent');
  }
  updateTemperatures(temp,date){
    var data ={"temperature":temp,"date":date};
    return this.http.post(this.baseUrl+'update',JSON.stringify(data));
  }
}
