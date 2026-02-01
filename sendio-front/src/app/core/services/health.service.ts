import { inject, Injectable } from '@angular/core';
import { environment } from '../../../environments/environment.development';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class HealthService {
  private readonly baseUrl = environment.apiUrl;

  private http = inject(HttpClient);

  checkStatus() {
    return this.http.get<{ status: string }>(`${this.baseUrl}/up`);
  }
}
