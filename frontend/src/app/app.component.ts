import { Component } from '@angular/core';

import { Statistics } from './statistics.model';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app';

  stats: Statistics;

  constructor() {
    this.stats = new Statistics();
   }

  setStats(respondsStats: Statistics): void {
    this.stats = respondsStats;
    console.log(respondsStats.class);
  }
}
