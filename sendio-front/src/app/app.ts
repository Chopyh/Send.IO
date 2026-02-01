import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { HealthCheck } from "./shared/components/health-check/health-check.component";

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, HealthCheck],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  protected readonly title = signal('sendio-front');
}
