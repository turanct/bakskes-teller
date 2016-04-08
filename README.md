# Bakskes Teller

![Bakske Bier](http://skylimiet.weebly.com/uploads/5/6/0/9/56092199/s914222581721252391_p2_i6_w500.jpeg)

## Goal

Count bakskes


## Flow

1. Someone (or multiple people) claim a bakske
2. The people they claim to own them a bakske are asked to admit defeat
3. If all losers admitted defeat, winners are notified they'll get their bakske
4. Winners can indicate when they got their bakske

![Flow](https://i.imgur.com/lKhlBhv.jpg)


## Implementation

- We'll use a simple event sourcing system at the core of the application. E.g.:
    - `BakskeWasClaimed`
    - `LoserAdmittedDefeat`
    - `AllLosersAdmittedDefeat`
    - `BakskeWasReceived`

- We'll use Email for default notifications, but keep options open so that we can add other methods in the future.
